<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3" style="margin-bottom:-10px">
          <?= $form->field($model, 'order_id')->textInput(['placeholder'=>'Order ID'])->label(false) ?>
      </div>
      <div class="col-md-3" style="margin-bottom:-10px">
        <?= $form->field($model, 'invoice_no')->textInput(['placeholder'=>'Invoice No'])->label(false) ?>
      </div>
      <div class="col-md-3" style="margin-bottom: -10px">

        <?php echo $form->field($model,'delivery_date')->label(false)->widget(DateRangePicker::classname(), [
          'useWithAddon'=>false,
          'convertFormat'=>true,
          'pluginOptions'=>[
            'locale'=>[
            //  'format'=> 'Y-m-d',
              'format'=> 'd M Y',
            ],
          ],
          'options'=>[
            'placeholder'=>'Delivery Date',
            'class'=>'form-control',
          ],
        ]); ?>
      </div>
      <div class="col-md-3" style="margin-bottom: -10px">
        <!---
          <?php  $form->field($model, 'product_code') ?>
          ---->
      </div>
      <div class="col-md-3" style="margin-bottom: -10px"  >
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class'=>'btn btn-default']) ?>
        </div>
      </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
