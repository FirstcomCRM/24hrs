<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use common\models\DeliveryTime;
/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */
/* @var $form yii\widgets\ActiveForm */

$data = DeliveryTime::find()->all();
$del = ArrayHelper::map($data,'delivery_time','delivery_time');


?>


<?php $form = ActiveForm::begin(['id' => 'delup-form']); ?>
  <div class="panel panel-info">
    <div class="panel-heading" style="padding-bottom:2px;">
      <div class="row">

        <div class="col-xs-6">
          <h3 class="panel-title">Delivery Settings</h3>
        </div>
        <div class="col-xs-5 text-right">
          <label>Special Delivery Time:</label>
        </div>
        <div class="col-xs-1 text-right">
            <?= Html::activeCheckbox($modelLine, 'delivery_trigger', ['label' => '', 'id'=>'del-trigger'])?>
        </div>

      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-xs-4">
            <?= $form->field($model, 'shipping_address_1')->label('Delivery Address')->textInput() ?>
            <?= $form->field($modelLine, 'sp_start')->widget(TimePicker::classname(), ['options'=>['class'=>'special-time form-control'] ]); ?>
            <?php echo $form->field($modelLine, 'standard_time')->dropDownList($del,['class'=>'standard-time form-control']) ?>

        </div>
        <div class="col-xs-4">

            <?php echo $form->field($modelLine, 'delivery_date')->widget(DatePicker::classname(), [
              'convertFormat'=>true,
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //  'type'=>1,
              'readonly' => true,
              'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'php:d M Y',
              ],
            ]); ?>
            <?= $form->field($modelLine, 'sp_end')->widget(TimePicker::classname(), ['options'=>['class'=>'special-time form-control'] ]); ?>

        </div>
        <div class="col-xs-4">
          <?= $form->field($modelLine, 'delivery_text_time')->label()->textInput(['disabled' => 'true']) ?>
        </div>
      </div>

      <div class="form-group">
          <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
      </div>

    </div>

  </div>


<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
    //alert("Hi");
    $(function() {
          delCheck();
          $('#del-trigger').click(function() {
            console.log('test');
            delCheck();
          });
    });

    function delCheck(){
      if($("#del-trigger").is(':checked')){
         // checked

         $(".field-orderproduct-sp_start").show();
         $(".field-orderproduct-sp_end").show();
         $(".field-orderproduct-standard_time").hide();
       }else{

         $(".field-orderproduct-standard_time").show();
         $(".field-orderproduct-sp_start").hide();
         $(".field-orderproduct-sp_end").hide();


       }
    }


JS;
$this->registerJs($script);
?>
