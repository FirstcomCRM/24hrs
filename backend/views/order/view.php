<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Order;
use common\models\OrderProduct;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

//$this->title = $model->order_id;
//$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

$path = '../web/logo/banner-en.jpg';
$defaults =  '../web/logo/defaults.jpg';
$npath = '';
$sums = [];

$parrs = OrderProduct::find()->where(['order_id'=>$model->order_id])->asArray()->all();
$pone = OrderProduct::find()->where(['order_id'=>$model->order_id])->one();
?>

<style>
  .panel-red{
    background-color: #A78D8C;
    color:white;
    font-weight: bold;
  }
  .pheader{
    color: #40090C;
    font-weight: bold;
  }
  .products{
    color: #FF0000;
    font-weight: bold;
  }
  .rborder{
    border-top:0px;
  }

  table,
  .order-view{
    font-family: Arial;
    font-size: 16px;
  }

  .table > tbody > tr > td{
    padding: 1px;
  }

  hr{
    border: 1px dotted black;
    border-style: none none dotted;
    color: #fff;
    background-color: #fff;
  }

  .adjust-margs{
    margin-bottom:10px;
    margin-top: -10px;
  }

  .hr-margs{
    margin-top: 1px;
    margin-bottom: 1px;
  }
  .table-margs{
    margin-bottom: 1px;
  }


</style>

<div class="order-view">

  <div class="panel panel-default adjust-margs">
    <div class="panel-body panel-red" style="padding:8px 10px">
      <div class="row">
        <div class="col-xs-6">
          Thank you <?php echo $model->firstname ?> for your order.
        </div>
        <div class="col-xs-6 text-right">
          Order No: #<?php echo $model->order_id ?>
        </div>
      </div>
    </div>
  </div>

  <span class="pheader"> Products:</span>


  <hr class="hr-margs">

  <table class="table table-margs">
    <?php foreach ($parrs as $k => $v): ?>
      <tr>
        <td style="width:50%;border-top:0px">[Product code : <span class="products"> <?php echo $v['product_id'] ?></span>] <?php echo $v['quantity'] ?>x
          <?php echo $v['name'] ?>
        </td>
        <?php $sums[] = $v['price'] ?>
        <td style="width:25%;border-top:0px"><?php echo '$'.number_format($v['price'],2)  ?></td>
        <td style="width:25%;border-top:0px">
          <?php
            $images = Product::find()->where(['product_id'=>$v['product_id']])->one();
            $search_path = Yii::getAlias('@roots').'/image/'.$images->image;
         ?>
         <?php if (file_exists($search_path)): ?>
           <?php $npath = Yii::getAlias('@image').'/'.$images->image; ?>
           <img src="<?php echo $npath ?>" alt="" height:"auto" width="50%">
          <?php else: ?>
            <img src="<?php echo $defaults ?>" alt="">
         <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>


  </table>

  <hr style="margin-bottom:10px">

  <table class="table table-margs">
    <tr>
      <td style="width:50%;border-top:0px" class="rborder">SubTotal</td>
      <td style="width:25%;border-top:0px" class="rborder"><?php echo '$'.number_format(array_sum($sums),2) ?></td>
      <td style="border-top:0px"></td>
    </tr>
    <tr>
      <td style="width:50%;border-top:0px">GST</td>
      <td style="width:25%;border-top:0px">$0.00</td>
      <td style="border-top:0px"></td>
    </tr>
    <tr>
      <td style="width:50%;border-top:0px"><strong>Total Paid:</strong> </td>
      <td style="width:25%;border-top:0px"><?php echo '$'.number_format($model->total,2)  ?></td>
      <td style="border-top:0px"></td>
    </tr>

  </table>


  <div class="row">
    <div class="col-xs-6">
      <span class="pheader">Recipient's Info :</span>
    </div>
    <div class="col-xs-6">
      <span class="pheader">Delivery Date & Time :</span>
    </div>
  </div>

  <hr class="hr-margs">

  <div class="row">
    <div class="col-xs-6">
      <?php if (!empty($model->shipping_firstname)): ?>
          <?php echo $model->shipping_firstname ?><br>
      <?php endif; ?>
      <?php if (!empty($model->shipping_company)): ?>
        <?php echo $model->shipping_company ?><br>
      <?php endif; ?>
      <?php if (!empty($model->shipping_address_1)): ?>
        <?php echo $model->shipping_address_1 ?><br>
      <?php endif; ?>
      <?php if (!empty($model->shipping_postcode)): ?>
        <?php echo $model->shipping_postcode ?><br>
      <?php endif; ?>
      <?php if (!empty($model->shipping_country)): ?>
        <?php echo $model->shipping_country ?><br>
      <?php endif; ?>
      <?php if (!empty($model->shipping_telephone)): ?>
        <?php echo $model->shipping_telephone ?>
      <?php endif; ?>

    </div>
    <div class="col-xs-6">
      <strong>Delivery Date:</strong>
        <?php
          if ($pone->delivery_date == '1970-01-01') {
            echo date('l d M Y', strtotime($pone->collection_date) );
          }else{
            echo date('l d M Y', strtotime($pone->delivery_date) );
          }

        ?>
      <br>
      <strong>Delivery Time:</strong>   <?php echo $pone->delivery_text_time ?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6">
      <span class="pheader">Sender's Info :</span>
    </div>
    <div class="col-xs-6">
      <span class="pheader">Gift Message :</span>
    </div>
  </div>

  <hr class="hr-margs">

  <div class="row">
    <div class="col-xs-6">
      <strong><?php echo $model->firstname ?></strong> <br>
      <?php echo $model->payment_country ?><br>
      Email: <?= Html::mailto($model->email, $model->email) ?><br>
      Tel: <?php echo $model->telephone ?><br>
      <strong><?php echo $model->order_source ?></strong> <br>
    </div>
    <div class="col-xs-6">
      <strong>To :</strong><?php echo $pone->gift_to ?>
      <br>
      <strong>Message :</strong> <?php echo  nl2br($pone->gift_message_comment) ?>
      <strong>From:</strong> <?php echo $pone->gift_from ?>
    </div>
  </div>


</div>
