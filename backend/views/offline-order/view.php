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
        <?= Html::a('Print Inv-DO', ['offline-order/print-dinv', 'id'=>$model->id], ['class' => 'btn btn-info','target'=>'_blanks']) ?>
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
                'delivery_time',

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
          <table class="table table-bordered">
            <thead>
              <th style="width:20%">Category</th>
              <th style="width:20%">Product Code</th>
              <th style="width:30%">Description</th>
              <th style="width:10%">Quantity</th>
              <th style="width:10%">Unit Price</th>
              <th style="width:10%">Total Amount</th>
            </thead>
            <?php foreach ($modelLine as $key => $value): ?>
                <tr>
                  <td><?php echo $value['off_category'] ?></td>
                  <td><?php echo $value['item_code'] ?></td>
                  <td><?php echo $value['description'] ?></td>
                  <td style="text-align:right"><?php echo $value['quantity'] ?></td>
                  <td style="text-align:right"><?php echo '$'.number_format($value['unit_price'],2) ?></td>
                  <td style="text-align:right"><?php echo '$'.number_format($value['total_amount'],2) ?></td>
                </tr>
            <?php endforeach; ?>
          </table>
          <table class="table">
            <tr>
              <td style="width:20%;border-top:0px"></td>
              <td style="width:20%;border-top:0px"></td>
              <td style="width:30%;border-top:0px"></td>
              <td style="width:20%;text-align:right;border-top:0px" colspan=2><label>SubTotal</label></td>
              <td style="width:10%;text-align:right;border-top:0px"><?php echo '$'.number_format($model->subtotal,2) ?></td>
            </tr>
            <tr>
              <td style="width:20%;border-top:0px"></td>
              <td style="width:20%;border-top:0px"></td>
              <td style="width:30%;border-top:0px"></td>
              <td style="width:20%;text-align:right;border-top:0px" colspan=2><label>Delivery Chrarge</label></td>
              <td style="width:10%;text-align:right;border-top:0px"><?php echo '$'.number_format($model->charge,2) ?></td>
            </tr>
            <tr>
              <td style="width:20%;border-top:0px"></td>
              <td style="width:20%;border-top:0px"></td>
              <td style="width:30%;border-top:0px"></td>
              <td style="width:20%;text-align:right;border-top:0px" colspan=2><label>Grand Total</label></td>
              <td style="width:10%;text-align:right;border-top:0px"><?php echo '$'.number_format($model->grand_total,2) ?></td>
            </tr>

          </table>
      </div>
    </div>


</div>
