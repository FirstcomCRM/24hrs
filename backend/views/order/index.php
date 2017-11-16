<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Management System';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?php Html::encode($this->title) ?></h1>
    <?php  $this->render('_search', ['model' => $searchModel]); ?>
    <?php echo $time ?>
    <?php Pjax::begin(); ?>
      <?= GridView::widget([
            'dataProvider' => $dataProvider,
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
                  'value'=>'orderProduct.product_id',
                ],
                [
                  'attribute'=>'image',
                  'value'=>'orderProduct.product.image',
                ],
                'order_status_id',

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
