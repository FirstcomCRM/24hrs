<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\OfflineOrderProduct;
use common\models\OrderProduct;
use yii\helpers\Url;

use common\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OfflineOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offline Order';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body">
        <p class="text-right">
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
              //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                //    'id',
                    'invoice_no',
                    [
                      'attribute'=>'invoice_date',
                      'format' => ['date', 'php:d M Y']
                    ],
                    [
                      'attribute'=>'delivery_date',
                      'format' => ['date', 'php:d M Y']
                    ],
                    [
                      'attribute'=>'delivery_time',
                      'label'=>'Delivery Time',
                    ],
                    
                    'customer_name',
                    'contact_number',
                    [
                      'attribute'=>'grand_total',
                    //  'format'=>['decimal',2],
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'footerOptions'=>['style' => 'text-align:right'],
                      'footer'=>'<strong>Total</strong>',
                      'value'=>function($model){
                          return '$'.number_format($model->grand_total,2);
                      }
                    ],

                    [
                      'header'=>'Action',
                      'class'=>'yii\grid\ActionColumn',
                      'template'=>'{view}  {update}  {delete} {print}',
                      'buttons'=>[
                        'view'=>function($url,$model, $key){
                          return Html::a(' <i class="fa fa-eye fa-lg fa-4x" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title' => Yii::t('app', 'View'),'data-pjax'=>0, 'target'=>'_blank',
                          ]);
                        },

                        'update'=>function($url,$model){
                          return Html::a(' <i class="fa fa-pencil-square-o fa-lg fa-4x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
                          ]);
                        },

                        'delete'=>function($url,$model){
                          return Html::a(' <i class="fa fa-trash fa-lg fa-4x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'class'=>'ipads btn btn-danger btn-s', 'title'=>Yii::t('app','Delete'),'data-pjax'=>0,
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                          ]);
                        },

                        'print'=>function($url,$model){
                          return Html::a(' <i class="fa fa-print fa-lg fa-4x" aria-hidden="true"></i>',['offline-order/print-dinv', 'id'=>$model['id'] ],['class'=>'ipads btn btn-info btn-s','target'=>'_blanks', 'title'=>Yii::t('app','Print'),'data-pjax'=>0,
                          ]);
                        }

                      ],
                    ],

                ],
            ]); ?>
      </div>
    </div>

    <?php Pjax::end(); ?>
</div>
