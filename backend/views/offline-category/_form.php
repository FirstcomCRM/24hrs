<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offline-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'off_category')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
