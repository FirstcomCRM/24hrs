<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(['id' => 'email-form']); ?>

  <?= $form->field($model, 'email') ?>

  <?= $form->field($model, 'title') ?>

  <?= $form->field($model, 'cc')->textarea(['rows' => 4]) ?>

  <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>


  <div class="form-group">
      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
  </div>
<?php ActiveForm::end(); ?>
