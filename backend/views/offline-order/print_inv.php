<?php

use common\models\OfflinePayment;

$i = 1;
$sum = [];


$datum= OfflinePayment::find()->where(['id'=>$model->payment])->one();
if (!empty($datum)) {
  $payments = $datum->payment_method;
}else{
  $payments = null;
}

 ?>
<style>

  body{
    font-family: Arial;
  }

  table{
    width:100%;
    border-collapse: collapse;
  }

  .test{
    vertical-align: top;
  }

  .header-a{
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

  .tax-left,
  .tax-right{
    width: 50%;
  }

  .tests{
    font-size: 11px;
  }

</style>


<table class="title-area" border=0>
  <tr>
    <td><img src="../web/logo/logo.jpg" alt=""></td>
    <td>
      <p class="tests"><h4>24HRS CITY FLORIST</h4></p>
      <p>161 Lavender Street #01-05 Singapore 338750  Tel: 63964222</p>
      <p>Fax: 6396 4236 </p>
      <p>Facebook: facebook.com/cityflorist</p>
      <p>Instagram: instagram/24hrscityflorist</p>
      <p>Website: www.24hrscityflorist.com</p>
    </td>
    <td class="test"><?php echo $model->invoice_no ?></td>
  </tr>
</table>

<hr>

<table class="tax-invoice">
  <tr>
    <td class="tax-left"> <h2>TAX INVOICE</h2> </td>
    <td class="tax-right" style="text-align:right">
      <strong>PURCHASE DATE:</strong> <?php echo date('d M Y',strtotime($model->invoice_date)) ?>
    </td>
  </tr>
</table>

<br>

<div class="header-a">
  <table border=0>
    <tr>
      <td style="width:25%" class="pads"><strong>CUSTOMER NAME:</strong></td>
      <td style="width:25%" class="pads"><?php echo $model->customer_name ?></td>
      <td style="width:25%" class="pads"><strong>CONTACT NUMBER:</strong> </td>
      <td style="width:25%" class="pads"><?php echo $model->contact_number ?></td>
    </tr>
    <tr>
      <td style="width:25%" class="pads"><strong>CUSTOMER EMAIL:</strong></td>
      <td style="width:25%" class="pads"><?php echo $model->email ?></td>
    </tr>
  </table>
</div>

<br>

<div class="tax-order">
  <table class="table-order" border=1>
    <thead>
      <tr>
        <th>SN</th>
        <th>ITEM CODE</th>
        <th>UNIT PRICE</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach ($modelLine as $key => $value): ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"><?php echo $value['item_code'] ?></td>
            <td class="pads" style="text-align:right"><?php echo '$'. number_format($value['unit_price'],2)?></td>
          </tr>
          <?php $sum[] =  $value['unit_price']?>
          <?php $i++ ?>
        <?php endforeach; ?>
      </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td class="pads" style="text-align:right"> <strong>TOTAL:</strong> </td>
        <td class="pads" style="text-align:right"><?php echo '$'.number_format(array_sum($sum),2) ?></td>
      </tr>
    </tfoot>
  </table>
</div>

<br>

<div class="header-a">
  <table border=0>
    <tr>
      <td style="width:15%; vertical-align:top; padding:5px"><strong>Message:</strong> </td>
      <td style="padding:5px;">
        <?php  echo nl2br($model->remarks) ?>
      </td>
  </table>
</div>

<br>

<div class="header-a">
  <table border=0>
    <tr>
      <td class="pads" colspan=4><strong>PAYMENT METHOD:</strong> <?php echo $payments ?></td>

    </tr>
    <tr>
      <td class="pads" style="width:15%"><strong>TAKEN BY:</strong> </td>
      <td class="pads" style="width:25%">Jerry</td>
      <td class="pads" style="width:35%;text-align:right"><strong>CUSTOMER SIGNATURE</strong></td>
      <td class="pads" style="width:20%">____________________________</td>
    </tr>
  </table>
</div>

<h6>Goods sold are not refundable or returnable</h6>
