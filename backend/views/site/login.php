<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        <div class="col-md-3">

        </div>

        <div class="col-md-6">
          <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">24 Hrs Order System</h3>
              </div>
              <div class="panel-body">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-sign-in" aria-hidden="true"></i> Login', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
                </div>
              </div>
              <div class="panel-footer text-center">
                @<?php echo date('Y') ?> Powered by <?php echo Html::a('Firstcom Solutions','https://www.firstcom.com.sg/'); ?>
              </div>
            </div>


          <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
