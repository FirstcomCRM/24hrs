<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\DeliveryTime;
use common\models\OfflinePayment;
use common\models\OfflineCategory;
/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

$this->title = $model->invoice_no;
//$this->params['breadcrumbs'][] = ['label' => 'Offline Order', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$total = 0;
foreach ($dataProvider->getModels() as $key => $value) {
  $total += $value->total_amount;
}


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
                  'value'=>function($model){
                    return '$'.number_format($model->charge,2);
                  }
                //  'format'=>['decimal',2]
                ],

                [
                  'attribute'=>'grand_total',
                  'value'=>function($model){
                    return '$'.number_format($model->grand_total,2);
                  }
                  //'format'=>['decimal',2]
                ],
                'remarks:ntext',
              //  'payment',
                [
                  'attribute'=>'payment',
                  'value'=>function($model){
                    $data = OfflinePayment::find()->where(['id'=>$model->payment])->one();
                    if (!empty($data)  ) {
                        return $data->payment_method;
                    }else{
                      return $data = null;
                    }

                  }
                ],
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
            'showFooter'=>TRUE,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                  'attribute'=>'category',
                  'value'=>function($model){
                    $data = OfflineCategory::find()->where(['id'=>$model->category])->one();
                    if (!empty($data)) {
                      return $data->off_category;
                    }else{
                      return $data = null;
                    }

                  }
                ],
                'item_code',
                //'quantity:decimal',
                [
                  'attribute'=>'quantity',
                   'format'=>['decimal',2],
                   'headerOptions' => ['style'=>'text-align:right'],
                   'contentOptions' => ['style' => 'text-align:right'],
                   'footerOptions'=>['style' => 'text-align:right'],
                ],
                [
                  'attribute'=>'unit_price',
                //  'format'=>['decimal',2],
                  'headerOptions' => ['style'=>'text-align:right'],
                  'contentOptions' => ['style' => 'text-align:right'],
                  'footerOptions'=>['style' => 'text-align:right'],
                  'footer'=>'<strong>Total</strong>',
                  'value'=>function($model){
                      return '$'.number_format($model->unit_price,2);
                  }
                ],
                [
                  'attribute'=>'total_amount',
                  'headerOptions' => ['style'=>'text-align:right'],
                  'contentOptions' => ['style' => 'text-align:right'],
                  'footerOptions'=>['style' => 'text-align:right'],
                //  'format'=>['decimal',2],
                  'footer' => '$'.number_format($total,2),
                  'value'=>function($model){
                    return '$'.number_format($model->total_amount,2);
                  }
                ]

            //    ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>


</div>
