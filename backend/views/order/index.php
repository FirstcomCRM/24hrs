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
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//gridcolumn used by Order today and pending future orders
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
],
[
  'attribute'=>'del_time',
  'label'=>'Delivery Time',
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
      return date('Y-m-d',strtotime($model['invoice_date']));
    }
  },
],
[
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
],
[
  'attribute'=>'status',
  'label'=>'Status',
  'value'=>function($model){
    $data = OrderStatus::findOne($model['status']);
    return $data->name;
  },
],

 /*[
    'attribute'=>'image',
    'label'=>'Image',
    'format'=>'raw',
    'value'=>function($model){
        $data = OrderProduct::find()->where(['order_id'=>$model->order_id])->one();
        if (!empty($data)) {
            $pdata = Product::find()->where(['product_id'=>$data->product_id])->one();
        }else{
          return $data = null;
        }

        if (!empty($pdata) ) {
          $path = Yii::getAlias('@image').'/'.$pdata->image;
          return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
        }else{
          return $pdata = null;
        }

    },
  ],*/

[
  'header'=>'Action',
  'class'=>'yii\grid\ActionColumn',
//  'template'=>'{view} {update}{email}{mod_email}{complete}{cancel}',
  'template'=>'{view} {update}{email}{complete}{cancel}',
  'options'=>['style'=>'padding:20px'],
  'buttons'=>[
    'view'=>function($url,$model, $key){
      return Html::a(' <i class="fa fa-eye fa-lg" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'title' => Yii::t('app', 'View'),'data-pjax'=>0,
      ]);
    },
    'update'=>function($url,$model){
      return Html::a(' <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
      ]);
    },
  /*  'email'=>function($url,$model,$key){
          return Html::a('<i class="fa fa-envelope-open-o " aria-hidden="true"></i>', '#', ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button',
          'onclick'=>'myEmail('.$model['id'] .')']);

    },*/
    'email'=>function($url,$model,$key){
          return Html::a('<i class="fa fa-envelope-open-o " aria-hidden="true"></i>', $url,
            [
              'title'=>'Email to customer',
              'data-pjax'=>0,
              'class'=>'modalButton',
            //  'value' => Url::to(['order/custom-email', 'id' => $key])
              'value' => Url::to(['order/custom-email'])
          //    'onclick'=>'myEmail('.$model['id'] .')'
            ]
          );

    },
    'complete'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['complete', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ], ['title'=>'Complete Order','data-pjax'=>0]);
    },
    'cancel'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', ['cancel', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'] ], ['title'=>'Cancel Order','data-pjax'=>0]);
    },
  ],
  'visibleButtons'=>[
    'view'=> function($model){
    //  return $model['invoice_no'] !='0'&& ($model['status'] != 5 );
      return $model['invoice_no'] !='0';
    },
    'update'=>function($model){
        return $model['invoice_no'] !='0' && ($model['status'] != 5 && $model['status'] != 7);
    },
    'complete'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7;
    },
    'cancel'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7;
    },
  ],
  'urlCreator'=> function($action,$model,$key,$index){
    if ($action ==='view'){
      //$url = '?r=offline-order%2Fview&id='.$model['id'];
      $url = Url::to(['offline-order/view', 'id'=>$model['id']]);
      return $url;
    }
    if ($action==='update') {
      //$url = '?r=offline-order%2Fupdate&id='.$model['id'];
      $url = Url::to(['offline-order/update', 'id'=>$model['id']]);
      return $url;
    }
    if ($action=='email') {
      $url = Url::to(['order/custom-email' ]);
      return $url;
    }

  }


],
];

$this->title = 'Order Management System';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">


<?php $test = '' ?>

    <h1><?php Html::encode($this->title) ?></h1>

    <div class="current-time well well-sm">
      <h4> Current Date/Time: <?php echo date('Y-m-d') ?> <span id=time></span></h4>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
          <?php echo  $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>


    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body"> <!--Start of the panel body for the Lists-->
        <p class="text-right"><?= Html::a('Create Offline Order', ['offline-order/create'], ['class' => 'btn btn-success']) ?></p>
        <ul class="nav nav-tabs">
          <li class="active"> <a href="#today" data-toggle="tab">Orders Today/Tomorrow</a></li>
          <li> <a href="#future" data-toggle="tab"> Pending Future Orders</a></li>
          <li> <a href="#completed" data-toggle="tab"> Orders Done</a></li>
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
