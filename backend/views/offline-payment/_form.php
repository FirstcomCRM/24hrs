<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OfflinePayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offline-payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
