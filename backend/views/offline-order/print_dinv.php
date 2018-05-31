<?php

use common\models\DeliveryTime;
use common\models\OfflinePayment;


$data = DeliveryTime::find()->where(['id'=>$model->delivery_time])->one();
$i = 1;


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
    font-size: 12px;
  }

  .test{
    vertical-align: top;
  }

  .header-block{
    border:1px solid black;
  }

  .block-label{
    width:30%;
  }
  .block-echo{
    width:20%;
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

  .tests{
    font-size: 11px;
  }

  .page-break{
    page-break-after: always;
  }


</style>

<?php

$testc = count($modelLine);

 ?>


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
            <?php if ($testc == 1): ?>
              <tr>
                <td class="pads"><?php echo $i ?></td>
                <td class="pads"></td>
                <td class="pads"></td>
              </tr>
              <?php $i++ ?>
              <tr>
                <td class="pads"> <?php echo $i ?></td>
                <td class="pads"></td>
                <td class="pads"></td>
              </tr>
            <?php elseif($testc == 2): ?>
              <tr>
                <td class="pads"> <?php echo $i ?></td>
                <td class="pads"></td>
                <td class="pads"></td>
              </tr>
            <?php endif; ?>

      </tbody>
    <tfoot>
      <?php if ($sum == null): ?>
        <?php $sum[] = 0; ?>
      <?php endif; ?>
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
      <td style="width:20%; vertical-align:top; padding:5px"><strong>Message:</strong> </td>
      <td style="padding:5px;">
        <?php echo nl2br($model->remarks) ?>
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


<hr>

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
    <td class="test">
      <p><h3>DELIVERY ORDER</h3></p>
      <br>
      <?php
    //    $data = $model->invoice_no;
      //  $strings = substr($model->invoice_no, 4);
          $strings = $model->invoice_no;
       ?>
       <h3><?php echo $strings ?></h3>
    </td>
  </tr>
</table>

<hr>

<div class="header-block">
  <table class="block" border=1>
    <tr>
      <td class="block-label" style:"font-family:Arial"><strong>RECIPIENT'S NAME:</strong> </td>
      <td class="block-echo"><?php echo $model->recipient_name ?></td>
      <td class="block-label"><strong>DELIVERY DATE:</strong> </td>
      <td class="block-echo"><?php echo $model->delivery_date ?></td>
    </tr>
    <tr>
      <td class="block-label"><strong>RECIPIENT'S CONTACT:</strong> </td>
      <td class="block-echo"><?php echo $model->recipient_contact_num ?></td>
      <td class="block-label"> <strong>DELIVERY TIME:</strong> </td>
      <td class="block-echo"><?php echo $model->delivery_time ?></td>
    </tr>
    <tr>
      <td class="block-label"><strong>DELIVERY ADDRESS:</strong> </td>
      <td class="block-echo" colspan="3">
        <?php echo $model->recipient_address ?>
      </td>
    </tr>
  </table>
</div>

<br>
<?php $i = 1 ?>

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
            <td class="pads" style="text-align:left"><?php echo number_format($value['quantity']) ?></td>
          </tr>
          <?php $i++ ?>
        <?php endforeach; ?>
        <?php if ($testc == 1): ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"></td>
            <td class="pads"></td>
          </tr>
          <?php $i++ ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"></td>
            <td class="pads"></td>
          </tr>
        <?php elseif($testc == 2): ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"></td>
            <td class="pads"></td>
          </tr>
        <?php endif; ?>
      </tbody>
  </table>
</div>

<br>

<div class="foots">
  <table class="table-foot">
    <tr>
      <td class="foot-left"><strong>Delivered By:</strong> </td>
      <td class="foot-right">
        <p><strong>Items Received in good order and condition</strong> </p>
        <br>
        <p>__________________________________________________</p>
      </td>
    </tr>

  </table>
</div>


<div class="page-break">

</div>

<!----
Print Do+DO
---->
<?php $i = 1 ?>

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
    <td class="test">
      <p><h3>DELIVERY ORDER</h3></p>
      <br>
      <?php
    //    $data = $model->invoice_no;
      //  $strings = substr($model->invoice_no, 4);
          $strings = $model->invoice_no;
       ?>
       <h3><?php echo $strings ?></h3>
    </td>
  </tr>
</table>

<hr>

<div class="header-block">
  <table class="block" border=0>
    <tr>
      <td class="block-label" style:"font-family:Arial"><strong>RECIPIENT'S NAME:</strong> </td>
      <td class="block-echo"><?php echo $model->recipient_name ?></td>
      <td class="block-label"><strong>DELIVERY DATE:</strong> </td>
      <td class="block-echo"><?php echo $model->delivery_date ?></td>
    </tr>
    <tr>
      <td class="block-label"><strong>RECIPIENT'S CONTACT:</strong> </td>
      <td class="block-echo"><?php echo $model->recipient_contact_num ?></td>
      <td class="block-label"> <strong>DELIVERY TIME:</strong> </td>
      <td class="block-echo"><?php echo $model->delivery_time ?></td>
    </tr>
    <tr>
      <td class="block-label"><strong>DELIVERY ADDRESS:</strong> </td>
      <td class="block-echo" colspan="3">
        <?php echo $model->recipient_address ?>
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
            <td class="pads" style="text-align:left"><?php echo number_format($value['quantity']) ?></td>
          </tr>
          <?php $i++ ?>
        <?php endforeach; ?>
          <?php if ($testc == 1): ?>
            <tr>
              <td class="pads"><?php echo $i ?></td>
              <td class="pads"></td>
              <td class="pads"></td>
            </tr>
            <?php $i++ ?>
            <tr>
              <td class="pads"> <?php echo $i ?></td>
              <td class="pads"></td>
              <td class="pads"></td>
            </tr>
          <?php elseif($testc == 2): ?>
            <tr>
              <td class="pads"> <?php echo $i ?></td>
              <td class="pads"></td>
              <td class="pads"></td>
            </tr>
          <?php endif; ?>
      </tbody>
  </table>
</div>

<br>

<div class="foots">
  <table class="table-foot">
    <tr>
      <td class="foot-left"><strong>Delivered By:</strong> </td>
      <td class="foot-right">
        <p><strong>Items Received in good order and condition</strong> </p>
        <br>
        <p>__________________________________________________</p>
      </td>
    </tr>

  </table>
</div>

<br>
<?php $i = 1 ?>

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
    <td class="test">
      <p><h3>DELIVERY ORDER</h3></p>
      <br>
      <?php
    //    $data = $model->invoice_no;
      //  $strings = substr($model->invoice_no, 4);
          $strings = $model->invoice_no;
       ?>
       <h3><?php echo $strings ?></h3>
    </td>
  </tr>
</table>

<hr>

<div class="header-block">
  <table class="block" border=0>
    <tr>
      <td class="block-label" style:"font-family:Arial"><strong>RECIPIENT'S NAME:</strong> </td>
      <td class="block-echo"><?php echo $model->recipient_name ?></td>
      <td class="block-label"><strong>DELIVERY DATE:</strong> </td>
      <td class="block-echo"><?php echo $model->delivery_date ?></td>
    </tr>
    <tr>
      <td class="block-label"><strong>RECIPIENT'S CONTACT:</strong> </td>
      <td class="block-echo"><?php echo $model->recipient_contact_num ?></td>
      <td class="block-label"> <strong>DELIVERY TIME:</strong> </td>
      <td class="block-echo"><?php echo $model->delivery_time ?></td>
    </tr>
    <tr>
      <td class="block-label"><strong>DELIVERY ADDRESS:</strong> </td>
      <td class="block-echo" colspan="3">
        <?php echo $model->recipient_address ?>
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
            <td class="pads" style="text-align:left"><?php echo number_format($value['quantity']) ?></td>
          </tr>
          <?php $i++ ?>
        <?php endforeach; ?>
        <?php if ($testc == 1): ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"></td>
            <td class="pads"></td>
          </tr>
          <?php $i++ ?>
          <tr>
            <td class="pads"> <?php echo $i ?></td>
            <td class="pads"></td>
            <td class="pads"></td>
          </tr>
        <?php elseif($testc == 2): ?>
          <tr>
            <td class="pads"> <?php echo $i ?></td>
            <td class="pads"></td>
            <td class="pads"></td>
          </tr>
        <?php endif; ?>
      </tbody>
  </table>
</div>

<br>

<div class="foots">
  <table class="table-foot">
    <tr>
      <td class="foot-left"><strong>Delivered By:</strong> </td>
      <td class="foot-right">
        <p><strong>Items Received in good order and condition</strong> </p>
        <br>
        <p>__________________________________________________</p>
      </td>
    </tr>

  </table>
</div>
