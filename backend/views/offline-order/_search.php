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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'invoice_no') ?>

    <?= $form->field($model, 'invoice_date') ?>

    <?= $form->field($model, 'delivery_date') ?>

    <?= $form->field($model, 'customer_name') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'contact_number') ?>

    <?php // echo $form->field($model, 'recipient_name') ?>

    <?php // echo $form->field($model, 'recipient_contact_num') ?>

    <?php // echo $form->field($model, 'recipient_address') ?>

    <?php // echo $form->field($model, 'recipient_email') ?>

    <?php // echo $form->field($model, 'recipient_postal_code') ?>

    <?php // echo $form->field($model, 'recipient_country') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
