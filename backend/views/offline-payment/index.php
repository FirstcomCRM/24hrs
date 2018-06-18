<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OfflinePaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Method';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-payment-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <p>
            <?= Html::a('Add Payment', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                'payment_method',

                [
                  'header'=>'Action',
                  'class'=>'yii\grid\ActionColumn',
                  'template'=>'{view}  {update}  {delete}',
                  'contentOptions'=>['style'=>'width:20%'],
                  'buttons'=>[
                    'view'=>function($url,$model, $key){
                      return Html::a(' <i class="fa fa-eye fa-lg fa-3x" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title' => Yii::t('app', 'View'),'data-pjax'=>0, 'target'=>'_blank',
                      ]);
                    },

                    'update'=>function($url,$model){
                      return Html::a(' <i class="fa fa-pencil-square-o fa-lg fa-3x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'class'=>'ipads btn btn-primary btn-s', 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
                      ]);
                    },

                    'delete'=>function($url,$model){
                      return Html::a(' <i class="fa fa-trash fa-lg fa-3x" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'class'=>'ipads btn btn-danger btn-s', 'title'=>Yii::t('app','Delete'),'data-pjax'=>0,
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                      ]);
                    },

                  ],
                ],
            ],
        ]); ?>
      </div>
    </div>


</div>
