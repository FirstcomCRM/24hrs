<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use common\models\DeliveryTime;
/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */
/* @var $form yii\widgets\ActiveForm */

$del_time = [
  '5:00pm - 9:00pm'=>'5:00pm - 9:00pm',
  '12:00am - 7:00am'=>'12:00am - 7:00am',
  '9:00am - 1:00pm'=>'9:00am - 1:00pm',
  '9:00pm - 12:00am'=>'9:00pm - 12:00am',
  '9:00am - 5:00pm'=>'9:00am - 5:00pm',
  '1:00pm - 5:00pm'=>'1:00pm - 5:00pm',
  '9:00am - 11:00am'=>'9:00am - 11:00am',
  '1:00pm - 9:00pm'=>'1:00pm - 9:00pm',
];

$data = DeliveryTime::find()->all();
$del = ArrayHelper::map($data,'id','delivery_time');
ksort($del_time);
?>

<div class="offline-order-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <!----Customer Panel Box--->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Your Information (Sender's Information)</h3>
      </div>
      <div class="panel-body">

        <div class="row">
          <div class="col-md-4">
            <?php $form->field($model, 'invoice_date')->textInput() ?>
            <?php echo $form->field($model, 'invoice_date')->widget(DatePicker::classname(), [
              'convertFormat'=>true,
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //  'type'=>1,
              'readonly' => true,
              'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'php:Y-m-d',
              ],
            ]); ?>
          </div>
          <div class="col-md-4">
            <?php $form->field($model, 'delivery_date')->textInput() ?>
            <?php echo $form->field($model, 'delivery_date')->widget(DatePicker::classname(), [
              'convertFormat'=>true,
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //  'type'=>1,
              'readonly' => true,
              'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'php:Y-m-d',
              ],
            ]); ?>
          </div>
          <div class="col-md-4">
              <?= $form->field($model, 'delivery_time')->dropDownList($del) ?>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
              <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-3">
            <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>
          </div>

          <div class="col-md-3">
            <?= $form->field($model, 'charge')->textInput(['maxlength' => true, 'onchange'=>'getCharge(), getGrandTotal()']) ?>
          </div>

            <div class="col-md-12">
                  <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>
            </div>

        </div>

      </div>
    </div>
    <!----Customer Panel BoxEnd --->

    <!----Recipient Panel Box--->
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Recipient's Information (Delivery Information)</h3>
      </div>
      <div class="panel-body">

        <div class="row">
          <div class="col-md-4">
              <?= $form->field($model, 'recipient_name')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-4">
              <?= $form->field($model, 'recipient_contact_num')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-4">
              <?= $form->field($model, 'recipient_address')->textarea(['rows' => 4]) ?>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
              <?= $form->field($model, 'recipient_email')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-4">
              <?= $form->field($model, 'recipient_postal_code')->textInput(['maxlength' => true]) ?>
          </div>

        </div>


      </div>
    </div>
    <!----Recipient Panel Box End--->

    <!--Dynamic table start here------->
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Order Details</h3>
        </div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 300, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelLine[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'item_code',
                    'quantity',
                    'unit_price',
                    'total_amount',

                ],
            ]); ?>

            <table class="table table-bordered container-items">
              <thead>
                <th></th>
                <th>Item Code</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
              </thead>
              <?php foreach ($modelLine as $i => $line): ?>
              <tr class="item">
                    <?php
                          if (! $line->isNewRecord) {
                              echo Html::activeHiddenInput($line, "[{$i}]id");
                          }
                    ?>
                    <td>
                      <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                      <button type="button" class="remove-item btn btn-danger btn-xs" id=<?php echo 'remove-'.$i.'-r' ?> onclick="offRecalc($(this))"><i class="glyphicon glyphicon-minus"></i></button>
                    </td>

                    <td>
                      <?= $form->field($line, "[{$i}]item_code")->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td>
                       <?= $form->field($line, "[{$i}]quantity")->textInput(['maxlength' => true, 'onchange'=>'getTotal($(this)), getGrandTotal()', 'placeholder'=>'0.00'])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]unit_price")->textInput(['maxlength' => true,'onchange'=>'getTotal($(this)), getGrandTotal()', 'placeholder'=>'0.00' ])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]total_amount")->textInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control sumPart', 'placeholder'=>'0.00'])->label(false) ?>
                    </td>
                    <?php endforeach; ?>
              </tr>
            </table>
            <div class="row total-area">
              <div class="col-md-8">

              </div>
              <div class="col-md-3">
                <?= $form->field($model, 'subtotal')->textInput(['readonly'=>true, 'placeholder'=>0.00, 'onchange'=>'getGrandTotal()']) ?>

                <b>Deliver Charge</b>
                <?= Html::input('text', 'username', $model->charge, ['class' => 'form-control', 'id'=>'ids','readonly'=>true, 'onchange'=>'getGrandTotal()']) ?>

                <?= $form->field($model, 'grand_total')->textInput(['readonly'=>true, 'placeholder'=>0.0]) ?>
              </div>
              <div class="col-md-1">

              </div>
            </div>


              </div>

          </div>
      <?php DynamicFormWidget::end(); ?>


    <!--Dynamic table ends here------->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
