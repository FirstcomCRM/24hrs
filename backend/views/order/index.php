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

[
    'header'=>'#',
    'class' => 'yii\grid\SerialColumn',
    'contentOptions' => ['style' => 'width:1%;'],
],

[
  'attribute'=>'id',
  'label'=>'Order ID',
  'contentOptions' => ['style' => 'width:5%;'],
],


[
  'attribute'=>'delivery_date',
  'label'=>'Delivery Date',
  'contentOptions' => ['style' => 'width:9%;'],
  'value'=>function($model){
    if ($model['delivery_date'] == '1970-01-01') {
      return date('d M Y', strtotime($model['coldate']) );
    }else{
      return date('d M Y', strtotime($model['delivery_date']) );
    }
  }
],

[
  'attribute'=>'del_time',
  'label'=>'Delivery Time',
  'contentOptions' => ['style' => 'width:10%;'],
  'value'=>function($model){
        if ($model['off_detect']!='77') {
            if ($model['del_time'] == '') {
               return $model['collect_text'];
            }else{
              return $model['del_time'];
            }
        }else{
            return $model['del_time'];
        }
  }

],


[
  'attribute'=>'invoice_no',
  'contentOptions' => ['style' => 'width:10%;'],
],
//'invoice_date',
[
  'attribute'=>'invoice_date',
  'contentOptions' => ['style' => 'width:10%;'],
  //'format' => ['date', 'php:Y-m-d'],
  'value'=>function($model){
    if ($model['invoice_date']== '0000-00-00 00:00:00' || is_null($model['invoice_date'])) {
      return '';
    }else{
      return date('d M Y',strtotime($model['invoice_date']));
    }
  },
],

[
  'attribute'=>'item_code',
  'contentOptions' => ['style' => 'width:10%;'],
],
//'off_detect',
[
  'attribute'=>'offremarks',
  'contentOptions' => ['style' => 'width:15%;'],
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
  'contentOptions' => ['style' => 'width:5%;'],
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
    'contentOptions' => ['style' => 'width:5%;'],
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
           $path = Yii::getAlias('@roots').'/image/'.$pdata->image;
          if (file_exists($path) ) {
            //  return 'exist';
            $path = Yii::getAlias('@image').'/'.$pdata->image;
            return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
          }else{
            $path = '../web/logo/defaults.jpg';
            //$path = Yii::getAlias('@image').'/'.$pdata->image;
            return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';

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
  'template'=>'{view}  {update}  {delup}  {email}  {remarks}   {complete}   {cancel}  {ship}',
//  'template'=>'{view}  {update}   {remarks}  ',
//  'options'=>['style'=>'padding:20px'],
  //'contentOptions' => ['style' => 'padding:20px;'],
  'buttons'=>[
    'view'=>function($url,$model, $key){
      return Html::a(' <i class="fa fa-eye fa-lg fa-3x" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title' => Yii::t('app', 'View'),'data-pjax'=>0, 'target'=>'_blank',
      ]);
    },
    'update'=>function($url,$model){
      return Html::a(' <i class="fa fa-pencil-square-o fa-lg fa-3x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
      ]);
    },
    'delup'=>function($url,$model){
      return Html::a(' <i class="fa fa-pencil fa-lg fa-3x" aria-hidden="true"></i>',$url,
        [
          'id'=>$model['id'],
          'class'=>'ipads btn btn-warning btn-s modalDelUp',
           'title'=>Yii::t('app','Edit'),
           'data-pjax'=>0,
           'value' => Url::to(['order/update-delivery', 'id'=>$model['id'] ])

      ]);
    },
    'email'=>function($url,$model,$key){
          return Html::a('<i class="fa fa-envelope-open-o fa-lg fa-3x" aria-hidden="true"></i>', $url,
            [
              'title'=>'Email to customer',
              'data-pjax'=>0,
              'class'=>'modalButton ipads btn btn-primary btn-s',
            //  'value' => Url::to(['order/custom-email', 'id' => $key])
              //'value' => Url::to(['order/custom-email'])
              'value' => Url::to(['order/custom-email', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'], 'off_detect'=>$model['off_detect']])
          //    'onclick'=>'myEmail('.$model['id'] .')'
            ]
          );

    },
    'complete'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-check fa-lg fa-3x" aria-hidden="true"></i>', ['complete', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Complete Order','data-pjax'=>0,
        'data' => [
            'confirm' => 'Are you sure you want to complete this item?',
            'method' => 'post',
        ],
        'class'=>'ipads btn btn-success btn-s',
      ]);
    },
    'cancel'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-times fa-lg fa-3x" aria-hidden="true"></i>', ['cancel', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Cancel Order','data-pjax'=>0,
        'data' => [
            'confirm' => 'Are you sure you want to cancel this item?',
            'method' => 'post',
        ],
        'class'=>'ipads btn btn-success btn-s',
      ]);
    },
    'ship'=>function($url,$model,$key){
      return Html::a('<i class="fa fa fa-car fa-lg fa-3x" aria-hidden="true"></i>', ['ship', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Ship Order','data-pjax'=>0,
        'data' => [
            'confirm' => 'Are you sure you want to ship this item?',
            'method' => 'post',
        ],
        'class'=>'ipads btn btn-success btn-s',
      ]);
    },
    'remarks'=>function($url,$model,$key){
      if ($model['off_detect'] == '77') {
        return Html::a('<i class="fa fa-bookmark fa-lg fa-3x" aria-hidden="true"></i>', ['offline-order/update-remark', 'id'=>$model['id'] ], ['title'=>'Remarks','data-pjax'=>0, 'class'=>'ipads btn btn-primary btn-s']);
      }else{
        return Html::a('<i class="fa fa-bookmark fa-lg fa-3x" aria-hidden="true"></i>', ['update-remark', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Remarks','data-pjax'=>0,'class'=>'ipads btn btn-primary btn-s']);
      }
    },

  ],
  'visibleButtons'=>[
    'update'=>function($model){
        return $model['off_detect'] =='77' && ($model['status'] != 5 && $model['status'] != 7  && $model['status'] != 3);
    },
    'delup'=>function($model){
        return $model['off_detect'] !='77' && ($model['status'] != 5 && $model['status'] != 7  && $model['status'] != 3);
    },
    'complete'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7 && $model['status']!=3;
    },
    'cancel'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7 && $model['status']!=3;
    },
    'ship'=>function($model){
      return $model['status'] != 1 && $model['status'] != 7 && $model['status'] != 3;
    },
  ],
  'urlCreator'=> function($action,$model,$key,$index){
    if ($action ==='view'){
      if ($model['off_detect']=='77') {
        $url = Url::to(['offline-order/view', 'id'=>$model['id']]);
      }else{
        $url = Url::to(['order/view', 'id'=>$model['id']]);
      }
      return $url;
    }
    if ($action==='update') {
      $url = Url::to(['offline-order/update', 'id'=>$model['id']]);
      return $url;
    }
    if ($action=='email') {
      $url = Url::to(['order/custom-email', 'id'=>$model['id'] ]);
      return $url;
    }
    if ($action=='delup') {
      $url = Url::to(['order/update-delivery', 'id'=>$model['id'] ]);
      return $url;
    }

  }


],
];

$doneGrid = [

[
    'header'=>'#',
    'class' => 'yii\grid\SerialColumn',
    'contentOptions' => ['style' => 'width:1%;'],
],

[
  'attribute'=>'id',
  'label'=>'Order ID',
  'contentOptions' => ['style' => 'width:5%;'],
],


[
  'attribute'=>'delivery_date',
  'label'=>'Delivery Date',
  'contentOptions' => ['style' => 'width:9%;'],
  'value'=>function($model){
    if ($model['delivery_date'] == '1970-01-01') {
      return date('d M Y', strtotime($model['coldate']) );
    }else{
      return date('d M Y', strtotime($model['delivery_date']) );
    }
  }
],

[
  'attribute'=>'del_time',
  'label'=>'Delivery Time',
  'contentOptions' => ['style' => 'width:10%;'],
  'value'=>function($model){
        if ($model['off_detect']!='77') {
            if ($model['del_time'] == '') {
               return $model['collect_text'];
            }else{
              return $model['del_time'];
            }
        }else{
            return $model['del_time'];
        }
  }

],


[
  'attribute'=>'invoice_no',
  'contentOptions' => ['style' => 'width:10%;'],
],
//'invoice_date',
[
  'attribute'=>'invoice_date',
  'contentOptions' => ['style' => 'width:10%;'],
  //'format' => ['date', 'php:Y-m-d'],
  'value'=>function($model){
    if ($model['invoice_date']== '0000-00-00 00:00:00' || is_null($model['invoice_date'])) {
      return '';
    }else{
      return date('d M Y',strtotime($model['invoice_date']));
    }
  },
],

[
  'attribute'=>'item_code',
  'contentOptions' => ['style' => 'width:10%;'],
],
//'off_detect',
[
  'attribute'=>'offremarks',
  'contentOptions' => ['style' => 'width:15%;'],
  'label'=>'Remarks',
  'format'=>'html',
  'value'=>function($model){
    return nl2br($model['offremarks']);
  }
],

[
  'attribute'=>'status',
  'label'=>'Status',
  'contentOptions' => ['style' => 'width:5%;'],
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
    'contentOptions' => ['style' => 'width:5%;'],
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
           $path = Yii::getAlias('@roots').'/image/'.$pdata->image;
          if (file_exists($path) ) {
            //  return 'exist';
            $path = Yii::getAlias('@image').'/'.$pdata->image;
            return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
          }else{
            $path = '../web/logo/defaults.jpg';
            //$path = Yii::getAlias('@image').'/'.$pdata->image;
            return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';

          }
        }else{
          return $pdata = null;
        }

    },
  ],


  [
    'attribute'=>'del_address',
    'label'=>'Delivery Address',
  ],

[
  'header'=>'Action',
  'class'=>'yii\grid\ActionColumn',
//  'template'=>'{view} {update}{email}{mod_email}{complete}{cancel}',
  'template'=>'{view}  {update}  {email}  {remarks}   {complete}   {cancel}  {ship}',
//  'template'=>'{view}  {update}   {remarks}  ',
//  'options'=>['style'=>'padding:20px'],
  //'contentOptions' => ['style' => 'padding:20px;'],
  'buttons'=>[
    'view'=>function($url,$model, $key){
      return Html::a(' <i class="fa fa-eye fa-lg fa-4x" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title' => Yii::t('app', 'View'),'data-pjax'=>0, 'target'=>'_blank',
      ]);
    },
    'update'=>function($url,$model){
      return Html::a(' <i class="fa fa-pencil-square-o fa-lg fa-3x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
      ]);
    },
    'email'=>function($url,$model,$key){
          return Html::a('<i class="fa fa-envelope-open-o fa-lg fa-3x" aria-hidden="true"></i>', $url,
            [
              'title'=>'Email to customer',
              'data-pjax'=>0,
              'class'=>'modalButton ipads btn btn-primary btn-s',

            //  'value' => Url::to(['order/custom-email', 'id' => $key])
              //'value' => Url::to(['order/custom-email'])
              'value' => Url::to(['order/custom-email', 'id'=>$model['id'], 'invoice_no'=>$model['invoice_no'], 'off_detect'=>$model['off_detect']])
          //    'onclick'=>'myEmail('.$model['id'] .')'
            ]
          );

    },
    'complete'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-check fa-lg fa-3x" aria-hidden="true"></i>', ['complete', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Complete Order','data-pjax'=>0,
        'data' => [
            'confirm' => 'Are you sure you want to complete this item?',
            'method' => 'post',
        ],
        'class'=>'ipads btn btn-success btn-s',
      ]);
    },
    'cancel'=>function($url,$model,$key){
      return Html::a('<i class="fa fa-times fa-lg fa-3x" aria-hidden="true"></i>', ['cancel', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Cancel Order','data-pjax'=>0,
        'data' => [
            'confirm' => 'Are you sure you want to cancel this item?',
            'method' => 'post',
        ],
        'class'=>'ipads btn btn-success btn-s',
      ]);
    },
    'ship'=>function($url,$model,$key){
      return Html::a('<i class="fa fa fa-car fa-lg fa-3x" aria-hidden="true"></i>', ['ship', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Ship Order','data-pjax'=>0,
        'data' => [
            'confirm' => 'Are you sure you want to ship this item?',
            'method' => 'post',
        ],
        'class'=>'ipads btn btn-success btn-s',
      ]);
    },
    'remarks'=>function($url,$model,$key){
      if ($model['off_detect'] == '77') {
        return Html::a('<i class="fa fa-bookmark fa-lg fa-3x" aria-hidden="true"></i>', ['offline-order/update-remark', 'id'=>$model['id'] ], ['title'=>'Remarks','data-pjax'=>0, 'class'=>'ipads btn btn-primary btn-s']);
      }else{
        return Html::a('<i class="fa fa-bookmark fa-lg fa-3x" aria-hidden="true"></i>', ['update-remark', 'id'=>$model['id'], 'off_detect'=>$model['off_detect'] ], ['title'=>'Remarks','data-pjax'=>0,'class'=>'ipads btn btn-primary btn-s']);
      }
    },

  ],
  'visibleButtons'=>[
    'update'=>function($model){
        return $model['off_detect'] =='77' && ($model['status'] != 5 && $model['status'] != 7  && $model['status'] != 3);
    },
    'complete'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7 && $model['status']!=3;
    },
    'cancel'=>function($model){
      return $model['status'] != 5 && $model['status'] != 7 && $model['status']!=3;
    },
    'ship'=>function($model){
      return $model['status'] != 1 && $model['status'] != 7 && $model['status'] != 3;
    },
  ],
  'urlCreator'=> function($action,$model,$key,$index){
    if ($action ==='view'){
      if ($model['off_detect']=='77') {
        $url = Url::to(['offline-order/view', 'id'=>$model['id']]);
      }else{
        $url = Url::to(['order/view', 'id'=>$model['id']]);
      }
      return $url;
    }
    if ($action==='update') {
      $url = Url::to(['offline-order/update', 'id'=>$model['id']]);
      return $url;
    }
    if ($action=='email') {
      $url = Url::to(['order/custom-email', 'id'=>$model['id'] ]);
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
          <li> <a href="#history" data-toggle="tab"> Order History</a></li>
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

          <div class="tab-pane fade table-responsive" id="future"><!--Start of Pending Future Order-->
            <?php Pjax::begin(['timeout' => 10000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_future,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  //  'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                ]); ?>
            <?php Pjax::end(); ?>
          </div><!--End of Pending Future Order-->

          <div class="tab-pane fade table-responsive" id="completed"><!--Start of Orders Done-->
            <?php Pjax::begin(['timeout' => 18000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_done,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  //  'filterModel' => $searchModel,
                  //  'columns' => $gridColumns,
                    'columns' => $doneGrid,
                ]); ?>
            <?php Pjax::end(); ?>
          </div><!--End of Orders Done-->

          <div class="tab-pane fade table-responsive" id="canceled"><!--Start of Orders Cancel-->
            <?php Pjax::begin(['timeout' => 18000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_cancel,
                     'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  //  'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                ]); ?>
            <?php Pjax::end(); ?>
          </div><!--End of Orders Cancel-->

          <div class="tab-pane fade table-responsive" id="history"><!--Start of Orders Cancel-->
            <?php Pjax::begin(['timeout' => 18000 ]); ?>
              <?= GridView::widget([
                    'dataProvider' => $dataProvider_shipped,
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
  Modal::begin([
    'header'=>'Update Delivery',
    'id'=>'modalsDelUp',
    'size'=>'modal-lg',
    //'clientOptions' => ['backdrop' => false],
    'footer' => '<a href="#" class="btn btn-info" data-dismiss="modal">Close</a>',
  //  'closeButton'=>'tag',
  ]);


 ?>

 <div class="" id="modalContentDel">

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
