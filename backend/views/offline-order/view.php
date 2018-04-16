<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\DeliveryTime;
/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

$this->title = $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'Offline Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-view">

    <p class="text-right">
        <?= Html::a('Back', ['order/index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Customer Information</h3>
      </div>
      <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [

                'invoice_no',
                [
                  'attribute'=>'invoice_date',
                  'format' => ['date', 'php:d M Y']
                ],
                [
                  'attribute'=>'delivery_date',
                  'format' => ['date', 'php:d M Y']
                ],

                /*[
                  'attribute'=>'delivery_time',
                  'value'=>function($model){
                    $data = DeliveryTime::find()->where(['id'=>$model->delivery_time])->one();
                    if (!empty($data)) {
                       return $data->delivery_time;
                    }else {
                      return $data = null;
                    }
                  }
                ],*/
                [
                  'attribute'=>'delivery_time_start',
                  'value'=>function($model){
                    return date('h:i A', strtotime($model->delivery_time_start) );
                  }
                ],
                [
                  'attribute'=>'delivery_time_end',
                  'value'=>function($model){
                    return date('h:i A', strtotime($model->delivery_time_end) );
                  }
                ],
                'customer_name',
                'email:email',
                'contact_number',

                [
                  'attribute'=>'charge',
                  'format'=>['decimal',2]
                ],

                [
                  'attribute'=>'grand_total',
                  'format'=>['decimal',2]
                ],
                'remarks:ntext',
                'payment',
                'recipient_name',
                'recipient_contact_num',
                'recipient_address:ntext',
                'recipient_email:email',
                'recipient_postal_code',

            ],
        ]) ?>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Order Details</h3>
      </div>
      <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'item_code',
                'quantity:decimal',

                [
                  'attribute'=>'unit_price',
                  'format'=>['decimal',2]
                ],
                [
                  'attribute'=>'total_amount',
                  'format'=>['decimal',2]
                ]

            //    ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>


</div>
