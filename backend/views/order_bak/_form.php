<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_no')->textInput() ?>

    <?= $form->field($model, 'invoice_prefix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'store_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'customer_group_id')->textInput() ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom_field')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_address_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_country_id')->textInput() ?>

    <?= $form->field($model, 'payment_zone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_zone_id')->textInput() ?>

    <?= $form->field($model, 'payment_address_format')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_custom_field')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_address_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_country_id')->textInput() ?>

    <?= $form->field($model, 'shipping_zone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_zone_id')->textInput() ?>

    <?= $form->field($model, 'shipping_address_format')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'shipping_custom_field')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'shipping_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_status_id')->textInput() ?>

    <?= $form->field($model, 'affiliate_id')->textInput() ?>

    <?= $form->field($model, 'commission')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketing_id')->textInput() ?>

    <?= $form->field($model, 'tracking')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_id')->textInput() ?>

    <?= $form->field($model, 'currency_id')->textInput() ?>

    <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forwarded_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_agent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accept_language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_added')->textInput() ?>

    <?= $form->field($model, 'date_modified')->textInput() ?>

    <?= $form->field($model, 'date_invoice')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
