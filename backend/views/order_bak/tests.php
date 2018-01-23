<?php
use common\models\Product;
use common\models\OrderProduct;

 ?>

<?php $arrs = ['abc','cde'] ?>

<?php

  $data = OrderProduct::find()->where(['order_id'=>$model->order_id])->all();
  foreach ($data as $key => $value) {
    $pdata = Product::find()->where(['product_id'=>$value->product_id])->all();
    foreach ($pdata as $key => $valuea) {
      $path = Yii::getAlias('@image').'/'.$valuea->image;
      //echo $valuea['image'].'<br>';

      echo '<a href="'.$path.'" data-pjax=0><img style="width:50px;" src="'.$path.'"></a>';
      //echo $path.'<br>';
    }
  }


 ?>
