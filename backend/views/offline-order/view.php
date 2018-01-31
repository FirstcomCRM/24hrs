<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

//$this->title = $model->invoice_no;
//$this->params['breadcrumbs'][] = ['label' => 'Offline Orders', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
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
                'invoice_date',
                'delivery_date',
                'delivery_time',
                'customer_name',
                'email:email',
                'contact_number',
                'remarks:ntext',
                'recipient_name',
                'recipient_contact_num',
                'recipient_address:ntext',
                'recipient_email:email',
                'recipient_postal_code',
                'recipient_country',
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
