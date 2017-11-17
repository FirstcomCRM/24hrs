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
      <div class="col-md-3">
          <?= $form->field($model, 'order_id') ?>
      </div>
      <div class="col-md-3">
        <?= $form->field($model, 'invoice_no') ?>
      </div>
      <div class="col-md-3">

        <?php echo $form->field($model,'delivery_date')->label()->widget(DateRangePicker::classname(), [
          'useWithAddon'=>false,
          'convertFormat'=>true,
          'pluginOptions'=>[
            'locale'=>[
              'format'=> 'Y-m-d',
            ],
          ],
          'options'=>[
            'placeholder'=>'Date',
            'class'=>'form-control',
          ],
        ]); ?>
      </div>
      <div class="col-md-3">
          <?= $form->field($model, 'product_code') ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
