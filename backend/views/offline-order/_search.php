<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offline-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-3">
              <?= $form->field($model, 'invoice_no') ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'invoice_date') ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'delivery_date') ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'customer_name') ?>
          </div>

      </div>
      <div class="form-group">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
      </div>
    </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>
