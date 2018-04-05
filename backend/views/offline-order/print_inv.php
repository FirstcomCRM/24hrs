<?php


$i = 1;
$sum = [];
 ?>
<style>
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
    <td class="test">Invoice</td>
  </tr>
</table>

<hr>

<table class="tax-invoice">
  <tr>
    <td class="tax-left"> <h4>TAX INVOICE</h4> </td>
    <td class="tax-right" style="text-align:right">
      Purchase Date: <?php echo date('d M Y',strtotime($model->invoice_date)) ?>
    </td>
  </tr>
</table>

<br>

<div class="header-a">
  <table border=0>
    <tr>
      <td>Customer Name</td>
      <td>Tesst test</td>
      <td>Contact Number</td>
      <td>1234</td>
    </tr>
    <tr>
      <td>Customer Email</td>
      <td>asdad@cc.c</td>
    </tr>
  </table>
</div>

<br>

<div class="tax-order">
  <table class="table-order" border=1>
    <thead>
      <tr>
        <th>SN</th>
        <th>Description</th>
        <th>Unit Price</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach ($modelLine as $key => $value): ?>
          <tr>
            <td class="pads"><?php echo $i ?></td>
            <td class="pads"><?php echo $value['item_code'] ?></td>
            <td class="pads"><?php echo '$'.$value['unit_price']?></td>
          </tr>
          <?php $sum[] =  $value['unit_price']?>
          <?php $i++ ?>
        <?php endforeach; ?>
      </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td>Total</td>
        <td><?php echo number_format(array_sum($sum),2) ?></td>
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
      <td class="pads">Payment Method</td>
      <td class="pads">??? CC</td>
    </tr>
    <tr>
      <td class="pads">Taken By:</td>
      <td class="pads">??? Jerry</td>
      <td class="pads">Customer Signature</td>
      <td class="pads">__________________</td>
    </tr>
  </table>
</div>

<h6>Goods sold are not refundable or returnable</h6>
