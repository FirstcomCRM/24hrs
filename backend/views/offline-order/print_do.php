<?php

use common\models\DeliveryTime;

$data = DeliveryTime::find()->where(['id'=>$model->delivery_time])->one();
$i = 1;
 ?>


<style>
  table{
    width:100%;
    border-collapse: collapse;
  }

  .test{
    vertical-align: top;
  }

  .header-block{
    border:1px solid black;
  }

  .block-label{
    width:25%;
  }
  .block-echo{
    width:25%;
  }

  .block-echo,
  .block-label,
  .pads{
    padding: 5px;
  }

  .foot-left,
  .foot-right{
    width: 50%;
  }


</style>


<table class="title-area" border=0>
  <tr>
    <td><img src="../web/logo/logo.jpg" alt=""></td>
    <td>
      <p><h4>24HRS CITY FLORIST</h4></p>
      <p>161 Lavender Street #01-05 Singapore 338750  Tel: 63964222</p>
      <p>Fax: 6396 4236 </p>
      <p>Facebook: facebook.com/cityflorist</p>
      <p>Instagram: instagram/24hrscityflorist</p>
      <p>Website: www.24hrscityflorist.com</p>
    </td>
    <td class="test">Delivery Order</td>
  </tr>
</table>

<hr>

<div class="header-block">
  <table class="block" border=0>
    <tr>
      <td class="block-label">Recipient's Name:</td>
      <td class="block-echo"><?php echo $model->recipient_name ?></td>
      <td class="block-label">Delivery Date:</td>
      <td class="block-echo"><?php echo $model->delivery_date ?></td>
    </tr>
    <tr>
      <td class="block-label">Recipient's Contact:</td>
      <td class="block-echo"><?php echo $model->recipient_contact_num ?></td>
      <td class="block-label">Delivery Time:</td>
      <td class="block-echo"><?php echo $data->delivery_time ?></td>
    </tr>
    <tr>
      <td class="block-label">Delivery Address</td>
      <td class="block-echo">
        <?php echo nl2br($model->recipient_address) ?>
      </td>
    </tr>
  </table>
</div>

<br>

<div class="delivery-order">
  <table class="table-order" border=1>
    <thead>
      <tr>
        <th>SN</th>
        <th>Description</th>
        <th>Quantity</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach ($modelLine as $key => $value): ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"><?php echo $value['item_code'] ?></td>
            <td class="pads"><?php echo $value['quantity']?></td>
          </tr>
          <?php $i++ ?>
        <?php endforeach; ?>
      </tbody>
  </table>
</div>

<br>

<div class="foots">
  <table class="table-foot">
    <tr>
      <td class="foot-left">Delivered By:</td>
      <td class="foot-right">
        <p>Items Received in good order and condition</p>
        <br>
        <p>___________________________________________</p>
      </td>
    </tr>

  </table>
</div>
