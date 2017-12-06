<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\Product;
use common\models\OrderProduct;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Management System';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?php Html::encode($this->title) ?></h1>
    <?php  $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
      <?= GridView::widget([
            'dataProvider' => $dataProvider_future,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                  'attribute'=>'delivery_text_time',
                  'value'=>'orderProduct.delivery_text_time',
                ],
                [
                  'attribute'=>'delivery_date',
                  'value'=>'orderProduct.delivery_date',
                ],
                  'order_id',
                  'invoice_no',
                  'invoice_prefix',
                [
                  'attribute'=>'product_id',
                //  'value'=>'orderProduct.product_id',
                  'format'=>'raw',
                  'value'=>function($model){
                      $prods = '';
                      $data = OrderProduct::find()->where(['order_id'=>$model->order_id])->asArray()->all();
                      foreach ($data as $key => $value) {
                        $prods .= $value['product_id'].'<br>';
                      }
                      return $prods;
                  },
                ],
                [
                  'attribute'=>'image',
                  'value'=>'orderProduct.product.image',
                ],
                'order_status_id',
                [
                  'attribute'=>'test',
                  'format'=>'raw',
                  'value'=>function($model){
                    return $this->render('tests',['model' => $model]);
                  },
                ],

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>

<hr>

<div class="test">
  <?=
  ListView::widget([
      'dataProvider' => $dataProvider_future,
      'options' => [
       'tag' => 'div',
       'class' => 'list-wrapper',
       'id' => 'list-wrapper',
   ],
   //'layout' => "{pager}\n{items}\n{summary}",
   'itemView' => function ($model, $key, $index, $widget) {
      return $this->render('tests',['model' => $model]);

    // or just do some echo
     //return $model->order_id . ' posted by ' . $model->order_id;
   },
  /* 'pager' => [
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'nextPageLabel' => 'next',
        'prevPageLabel' => 'previous',
        'maxButtonCount' => 3,
    ],*/
  ]);
  ?>
</div>




<?php


 ?>
