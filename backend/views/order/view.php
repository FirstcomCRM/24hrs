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
  hr{
    border: 1px dotted black;
    border-style: none none dotted;
    color: #fff;
    background-color: #fff;
  }


</style>

<div class="order-view">

  <div class="img-responsive">
    <img src="<?php echo $path ?>" alt="">
  </div>

  <br>
  <div class="panel panel-default">
    <div class="panel-body panel-red">
      <div class="row">
        <div class="col-md-6">
          Thank you <?php echo $model->firstname ?> for your order.
        </div>
        <div class="col-md-6 text-right">
          Order No: #<?php echo $model->order_id ?>
        </div>
      </div>
    </div>
  </div>


  <span class="pheader"> Products:</span>


  <hr>

  <table class="table">
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

  <hr>

  <table class="table">
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

  <br>
  <div class="row">
    <div class="col-md-6">
      <span class="pheader">Recipient's Info :</span>
    </div>
    <div class="col-md-6">
      <span class="pheader">Delivery Date & Time :</span>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-6">
      <p><?php echo $model->shipping_firstname ?></p>
      <p><?php echo $model->shipping_company ?></p>
      <p><?php echo $model->shipping_address_1 ?></p>
      <p><?php echo $model->shipping_postcode ?></p>
      <p><?php echo $model->shipping_country ?></p>
      <p>Tel: <?php echo $model->shipping_telephone ?></p>

    </div>
    <div class="col-md-6">
      <strong>Delivery Date:</strong>   <?php echo date('l d M Y', strtotime($pone->delivery_date) ) ?>
      <br>
      <strong>Delivery time:</strong>   <?php echo $pone->delivery_text_time ?>
    </div>
  </div>


  <br><br>
  <div class="row">
    <div class="col-md-6">
      <span class="pheader">Sender's Info :</span>
    </div>
    <div class="col-md-6">
      <span class="pheader">Gift Message :</span>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-6">
      <p><strong><?php echo $model->firstname ?></strong> </p>
      <p><?php echo $model->payment_country ?></p>
      <p>Email: <?= Html::mailto($model->email, $model->email) ?></p>
      <p>Tel: <?php echo $model->telephone ?></p>
      <p><strong><?php echo $model->order_source ?></strong> </p>
    </div>
    <div class="col-md-6">
      <strong>To :</strong><?php echo $pone->gift_to ?>
      <br>
      <strong>Message :</strong> <?php echo  nl2br($pone->gift_message_comment) ?>
      <strong>From:</strong> <?php echo $pone->gift_from ?>
    </div>
  </div>



</div>
