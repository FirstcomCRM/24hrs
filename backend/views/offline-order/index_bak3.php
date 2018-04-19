<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\OfflineOrderProduct;
use common\models\OrderProduct;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OfflineOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offline Order';
$this->params['breadcrumbs'][] = $this->title;
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
                    'customer_name',
                    //['class' => 'yii\grid\ActionColumn'],
                    [
                      'header'=>'Action',
                      'class'=>'yii\grid\ActionColumn',
                      'template'=>'{view}  {update}  {delete}  {do}  {inv}',
                      'buttons'=>[
                        'view'=>function($url,$model, $key){
                          return Html::a(' <i class="fa fa-eye fa-lg" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'class'=>'pads', 'title' => Yii::t('app', 'View'),'data-pjax'=>0,
                          ]);
                        },
                        'update'=>function($url,$model){
                          return Html::a(' <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
                          ]);
                        },

                        'delete'=>function($url,$model){
                          return Html::a('<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'title'=>Yii::t('app','Delete'),'data-pjax'=>0, 'data-method'=>'post',
                          ]);
                        },

                        'do'=>function($url,$model,$key){
                          return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['print-do', 'id'=>$model['id']  ], ['title'=>'Print DO','data-pjax'=>0]);
                        },
                        'inv'=>function($url,$model,$key){
                          return Html::a('<i class="fa fa-times" aria-hidden="true"></i>', ['print-inv', 'id'=>$model['id'] ], ['title'=>'Print Invoice','data-pjax'=>0]);
                        },
                      ],



                    ],

                ],
            ]); ?>
      </div>
    </div>

    <?php Pjax::end(); ?>
</div>
