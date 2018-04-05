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

$this->title = 'Offline Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-index">
  <pre>
    <?php// print_r($dataProvider->getModels()) ?>
  </pre>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Offline Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'invoice_no',
            [
              'attribute'=>'invoice_date',
              'format' => ['date', 'php:Y-m-d']
            ],
        //    'del_date',
        //    'del_time',
            //'item_code',
          /*  [
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


        /*    [
              'header'=>'Actions',
              'class'=>'yii\grid\ActionColumn',
              'template'=>'{view} {update}',

              'buttons'=>[
                'view'=>function($url,$model, $key){
                  return Html::a(' <i class="fa fa-eye fa-lg" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'title' => Yii::t('app', 'View'),'data-pjax'=>0,
                  ]);
                },
                'update'=>function($url,$model){
                  return Html::a(' <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
                  ]);
                },
              ],

              'visibleButtons'=>[
                'view'=> function($model){
                  return $model['invoice_no'] !='0';
                },
                'update'=>function($model){
                    return $model['invoice_no'] !='0';
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

              }

            ],*/
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
