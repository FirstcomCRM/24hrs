<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\Product;
use common\models\OrderProduct;
use common\models\OfflineOrderProduct;
use common\models\OrderStatus;
use common\models\DeliveryTime;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//gridcolumn used by Order today and pending future orders

//echo '<pre>';
//print_r($dataProvider->getModels() );
//die();

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],

// /    'id',
[
  'attribute'=>'id',
  'label'=>'Order ID',
],

[
  'attribute'=>'del_date',
  'label'=>'Delivery Date',
    'format' => ['date', 'php:d M Y']
],
//'offremarks',

[
  'attribute'=>'del_time',
  'label'=>'Delivery Time',
  'value'=>function($model){
        $tes = (int)$model['del_time'];
        if (is_numeric($model['del_time']) ) {
          $data = DeliveryTime::find()->where(['id'=>$model['del_time']])->one();
          if (!empty($data)) {
             return $data->id;
          }else {
            return $data = null;
        }
      }else{
        return $model['del_time'];
      }
  }

],

'invoice_no',
//'invoice_date',
[
  'attribute'=>'invoice_date',
  //'format' => ['date', 'php:Y-m-d'],
  'value'=>function($model){
    if ($model['invoice_date']== '0000-00-00 00:00:00' || is_null($model['invoice_date'])) {
      return '';
    }else{
      return date('d M Y',strtotime($model['invoice_date']));
    }
  },
],
'item_code',
[
  'attribute'=>'offremarks',
  'label'=>'Remarks',
  'format'=>'html',
  'value'=>function($model){
    return nl2br($model['offremarks']);
  }
],
/*[
  'attribute'=>'item_code',
  'format'=>'raw',
  'value'=>function($model){
      $prods = '';
      if ($model['invoice_no']!= '0') {
        $data = OfflineOrderProduct::find()->where(['off_order_id'=>$model['id'] ])->asArray()->all();
        foreach ($data as $key => $value) {
          $prods .= $value['item_code'].'<br>';
        }
      }else{
        $data = OrderProduct::find()->where(['order_id'=>$model['id'] ])->asArray()->all();
        foreach ($data as $key => $value) {
          $prods .= $value['product_id'].'<br>';
        }
      }

      return $prods;
  },
],*/

[
  'attribute'=>'status',
  'label'=>'Status',
  'value'=>function($model){
    $data = OrderStatus::findOne($model['status']);
    if ($model['status'] == '3') {
      $data->name = 'Delivered';
      return $data->name;
    }else{
        return $data->name;
    }

  },
],

 [
    'attribute'=>'image',
    'label'=>'Image',
    'format'=>'raw',
    'value'=>function($model){
        //$data = OrderProduct::find()->where(['order_id'=>$model->order_id])->one();
        $data = OrderProduct::find()->where(['order_id'=>$model['id'] ])->one();
        if (!empty($data)) {
            $pdata = Product::find()->where(['product_id'=>$data->product_id])->one();
        }else{
          return $data = null;
        }

        if (!empty($pdata) ) {
        //  $path = Yii::getAlias('@image').'/'.$pdata->image;
           $path = Yii::getAlias('@roots').'/image/'.$pdata->image;
          if (file_exists($path) ) {
            //  return 'exist';
            $path = Yii::getAlias('@image').'/'.$pdata->image;
            return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
          }else{
            $path = '../web/logo/defaults.jpg';
            //$path = Yii::getAlias('@image').'/'.$pdata->image;
            return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
            //return $path;

          }
        }else{
          return $pdata = null;
        }

    },
  ],

[
  'header'=>'Action',
  'class'=>'yii\grid\ActionColumn',
//  'template'=>'{view} {update}{email}{mod_email}{complete}{cancel}',
//  'template'=>'{view}  {update}  {email}  {remarks}   {complete}   {cancel}  {ship}',
  'template'=>'{view}  {update}   {remarks}   {complete}   {cancel}  {ship}',
//  'options'=>['style'=>'padding:20px'],
  //'contentOptions' => ['style' => 'padding:20px;'],
  'buttons'=>[
    'view'=>function($url,$model, $key){
      return Html::a(' <i class="fa fa-eye fa-lg fa-2x" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'class'=>'pads', 'title' => Yii::t('app', 'View'),'data-pjax'=>0, 'target'=>'_blank',
      ]);
    },
    'update'=>function($url,$model){
      return Html::a(' <i class="fa fa-pencil-square-o fa-lg fa-2x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
      ]);
    },
  /*  'email'=>function($url,$model,$key){
          return Html::a('<i class="fa fa-envelope-open-o " aria-hidden="true"></i>', '#', ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button',
          'onclick'=>'myEmail('.$model['id'] .')']);

    },*/
    'email'=>function($url,$model,$key){
          return Html::a('<i class="fa fa-envelope-open-o  fa-2x" aria-hidden="true"></i>', $url,
            [
              'title'=>'Email to customer',
              'data-pjax'=>0,
              'class'=>'modalButton',

            //  'value' => Url::to(['order/custom-email', 'id' => $key])
              //'value' => Url::to(['order/custom-email'])
              'value' => Url::to(['order/custom-email', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ])
          //    'onclick'=>'myEmail('.$model['id'] .')'
            ]
          );

    },
    'complete'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-check fa-2x" aria-hidden="true"></i>', ['complete', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ], ['title'=>'Complete Order','data-pjax'=>0]);
    },
    'cancel'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-times fa-2x" aria-hidden="true"></i>', ['cancel', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ], ['title'=>'Cancel Order','data-pjax'=>0]);
    },
    'ship'=>function($url,$model,$key){
      return Html::a('<i class="fa fa fa-car fa-2x" aria-hidden="true"></i>', ['ship', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ], ['title'=>'Ship Order','data-pjax'=>0]);
    },
    'remarks'=>function($url,$model,$key){
      if ($model['invoice_no'] != '0') {
        return Html::a('<i class="fa fa-bookmark fa-2x" aria-hidden="true"></i>', ['offline-order/update-remark', 'id'=>$model['id'] ], ['title'=>'Remarks','data-pjax'=>0]);

      }else{
        return Html::a('<i class="fa fa-bookmark fa-2x" aria-hidden="true"></i>', ['update-remark', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ], ['title'=>'Remarks','data-pjax'=>0]);
      }
    },

  ],
  'visibleButtons'=>[
    //'view'=> function($model){
    //  return $model['invoice_no'] !='0'&& ($model['status'] != 5 );
  //    return $model['invoice_no'] !='0';
  //  },
    'update'=>function($model){
        return $model['invoice_no'] !='0' && ($model['status'] != 5 && $model['status'] != 7);
    },
    'complete'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7 && $model['status']!=3;
    },
    'cancel'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7 && $model['status']!=3;
    },
    'ship'=>function($model){
      return $model['status'] != 1 && $model['status'] != 7;
    },
  ],
  'urlCreator'=> function($action,$model,$key,$index){
    if ($action ==='view'){
      //$url = '?r=offline-order%2Fview&id='.$model['id'];
      if ($model['invoice_no']!='0') {
        $url = Url::to(['offline-order/view', 'id'=>$model['id']]);
      }else{
        $url = Url::to(['order/view', 'id'=>$model['id']]);
      }

      return $url;
    }
    if ($action==='update') {
      //$url = '?r=offline-order%2Fupdate&id='.$model['id'];
      $url = Url::to(['offline-order/update', 'id'=>$model['id']]);
      return $url;
    }
    if ($action=='email') {
      $url = Url::to(['order/custom-email', 'id'=>$model['id'] ]);
    //  $url = Url::to(['order/test', 'id'=>$model['id'] ]);
    //  $url = Url::to(['order/custom-email', 'id'=>$model['id'], 'invoice_no'=> $model['invoice_no'] ]);
      return $url;
    }

  }


],
];

$this->title = 'Order Management System';
//$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.alignleft {
	float: left;
}
.alignright {
	float: right;
}
.textbox{
  overflow: hidden;
}
</style>

<div class="order-index">

    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-4">
            <h3 class="panel-title">Search</h3>
          </div>
          <div class="col-md-4">
            <strong>Current Date/Time: <?php echo date('Y-m-d') ?> <span id=time></span> </strong>

          </div>
          <div class="col-md-4 text-right">
              <?= Html::a('Create Offline Order', ['offline-order/create'], ['class' => 'btn btn-success btn-sm', 'style'=>'padding:2px 4px; font-size:10px;']) ?>
          </div>
        </div>

      </div>
      <div class="panel-body">
          <?php echo  $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <div class="panel panel-warning">

      <div class="panel-body"> <!--Start of the panel body for the Lists-->
        <ul class="nav nav-tabs">
          <li class="active"> <a href="#today" data-toggle="tab">Orders Today/Tomorrow</a></li>
          <li> <a href="#future" data-toggle="tab"> Pending Future Orders</a></li>
          <li> <a href="#completed" data-toggle="tab"> Orders Done</a></li>
          <li> <a href="#canceled" data-toggle="tab"> Orders Canceled</a></li>
        </ul>

        <br>
        <div class="tab-content">

          <div class="tab-pane fade in active" id="today"> <!--Start of Pending Orders for Today-->
            <div class="table-responsive">
              <?php Pjax::begin(['timeout' => 10000 ]); ?>
                <?= GridView::widget([
                      'dataProvider' => $dataProvider,
                    //  'filterModel' => $searchModel,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                      'columns' => $gridColumns,
                  ]); ?>
              <?php Pjax::end(); ?>
            </div>
          </div><!--End of Pending Orders for Today-->

          <div class="tab-pane fade" id="future"><!--Start of Pending Future Order-->
            <?php Pjax::begin(['timeout' => 10000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_future,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  //  'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                ]); ?>
            <?php Pjax::end(); ?>
          </div><!--End of Pending Future Order-->

          <div class="tab-pane fade" id="completed"><!--Start of Orders Done-->
            <?php Pjax::begin(['timeout' => 18000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_done,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  //  'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                ]); ?>
            <?php Pjax::end(); ?>
          </div><!--End of Orders Done-->

          <div class="tab-pane fade" id="canceled"><!--Start of Orders Cancel-->
            <?php Pjax::begin(['timeout' => 18000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_cancel,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  //  'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                ]); ?>
            <?php Pjax::end(); ?>
          </div><!--End of Orders Cancel-->

        </div>

      </div> <!--End of the panel body for the Lists-->
    </div>



</div>

<?php
  Modal::begin([
    'header'=>'Email to Customer',
    'id'=>'modals',
    'size'=>'modal-lg',
    //'clientOptions' => ['backdrop' => false],
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
  //  'closeButton'=>'tag',
  ]);

 ?>

<div class="" id="modalContent">

</div>

<?php Modal::end() ?>



<?php
$script = <<< JS
$(document).ready(function() {

  var myVar = setInterval(function(){ myTimer() }, 1000);

  function myTimer() {
      var d = new Date();
      var t = d.toLocaleTimeString();
      document.getElementById("time").innerHTML = t;
  }
});
JS;
$this->registerJs($script);
?>
