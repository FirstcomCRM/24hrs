<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\TimePicker;
use yii\helpers\ArrayHelper;
use common\models\DeliveryTime;
use common\models\OfflinePayment;
use common\models\OfflineCategory;
/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */
/* @var $form yii\widgets\ActiveForm */


$data = DeliveryTime::find()->all();
$del = ArrayHelper::map($data,'id','delivery_time');

$data = OfflinePayment::find()->all();
$payments = ArrayHelper::map($data,'id','payment_method');

$data = OfflineCategory::find()->all();
$cat = ArrayHelper::map($data,'id','off_category');

/*$payments = [
  'Cash on Hand'=>'Cash on Hand',
  'CC'=>'CC',

];*/

?>

<style>
  .panel-body{
      padding-bottom:1px;
  }
</style>



<div class="offline-order-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <!----Customer Panel Box--->
    <div class="panel panel-default">
      <div class="panel-heading" style="padding-bottom: 2px;">
        <h3 class="panel-title">Customer Information (Sender's Information)</h3>
      </div>
      <div class="panel-body">

        <div class="row">
          <div class="col-md-3">
            <?php $form->field($model, 'invoice_date')->textInput() ?>
            <?php echo $form->field($model, 'invoice_date')->widget(DatePicker::classname(), [
              'convertFormat'=>true,
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //  'type'=>1,
              'readonly' => true,
              'pluginOptions' => [
                'autoclose'=>true,
            //    'format' => 'php:Y-m-d',
                'format' => 'php:d M Y',
              ],
            ]); ?>
          </div>
          <div class="col-md-3">

            <?php echo $form->field($model, 'delivery_date')->widget(DatePicker::classname(), [
              'convertFormat'=>true,
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //  'type'=>1,
              'readonly' => true,
              'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'php:d M Y',
              ],
            ]); ?>
          </div>
          <div class="col-md-3">
            <?php $form->field($model, 'delivery_time')->dropDownList($del) ?>
            <?= $form->field($model, 'delivery_time_start')->widget(TimePicker::classname(), []); ?>
          </div>
          <div class="col-md-3">
            <?= $form->field($model, 'delivery_time_end')->widget(TimePicker::classname(), []); ?>
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

          <div class="col-md-3" style="margin-bottom: -10px;" >
              <?= $form->field($model, 'remarks')->textarea(['rows' => 2]) ?>
          </div>



        </div>

      </div>
    </div>
    <!----Customer Panel BoxEnd --->


    <!----Recipient Panel Box--->
    <div class="panel panel-default">
      <div class="panel-heading" style="padding-bottom: 2px;">
        <div class="row">
          <div class="col-md-6">
            <h3 class="panel-title">Recipient's Information (Delivery Information)</h3>
          </div>
          <div class="col-md-6 text-right">
              <?= Html::a('View Sample Message', null, ['class' => 'btn btn-default btn-xs modalButton', 'style'=>'margin-bottom:5px',
                      'value'=>Url::to(['offline-order/gift'])
                    //  'value' => Url::to(['order/custom-email'])
                      ])
             ?>
          </div>
        </div>
      </div>

      <div class="panel-body">

        <div class="row">
          <div class="col-md-3" style="margin-bottom: -10px;">
              <?= $form->field($model, 'recipient_name')->textInput(['maxlength' => true]) ?>
              <?= $form->field($model, 'recipient_email')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-3" style="margin-bottom: -10px;">
              <?= $form->field($model, 'recipient_contact_num')->textInput(['maxlength' => true]) ?>
              <?= $form->field($model, 'recipient_postal_code')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-3" style="margin-bottom: -10px;">
              <?= $form->field($model, 'recipient_address')->textarea(['rows' => 4]) ?>
          </div>
          <div class="col-md-3" style="margin-bottom: -10px;">
              <?= $form->field($model, 'gift_message')->textarea(['rows' => 4]) ?>
          </div>
        </div>


        <?php $form->field($model, 'gift_to')->textInput(['maxlength' => true]) ?>
        <?php $form->field($model, 'gift_from')->textInput(['maxlength' => true]) ?>


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
                'limit' => 5, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                //'min' => 3, // 0 or 1 (default 1)
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

            <table class="table table-bordered container-items" style="margin-bottom: 2px;">
              <thead>
                <th style="width:10%"></th>
                <th style="width:25%">Category</th>
                <th style="width:10%">Product Code</th>
                <th style="width:25%">Description</th>
                <th style="width:10%;text-align:right">Quantity</th>
                <th style="width:10%;text-align:right">Unit Price</th>
                <th style="width:10%;text-align:right" >Total Amount</th>
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
                      <?php $form->field($line, "[{$i}]category")->textInput(['maxlength' => true])->label(false) ?>
                      <?= $form->field($line, "[{$i}]category")->dropDownList($cat,['prompt'=>'Please Select'])->label(false) ?>

                    </td>

                    <td>
                      <?= $form->field($line, "[{$i}]item_code")->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]description")->textInput(['maxlength' => true])->label(false) ?>

                    </td>
                    <td>
                       <?= $form->field($line, "[{$i}]quantity")->textInput(['maxlength' => true, 'onchange'=>'getTotal($(this))', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]unit_price")->textInput(['maxlength' => true,'onchange'=>'getTotal($(this))', 'placeholder'=>'0.00','style'=>'text-align:right' ])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]total_amount_text")->textInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                      <?= $form->field($line, "[{$i}]total_amount")->hiddenInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control sumPart', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>

                    </td>
                    <?php endforeach; ?>
              </tr>

              <!--add two more line fields??---->
              <?php if ($line->isNewRecord): ?>
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
                          <?php $form->field($line, "[{$i}]category")->textInput(['maxlength' => true])->label(false) ?>
                          <?= $form->field($line, "[{$i}]category")->dropDownList($cat,['prompt'=>'Please Select'])->label(false) ?>

                        </td>

                        <td>
                          <?= $form->field($line, "[{$i}]item_code")->textInput(['maxlength' => true])->label(false) ?>
                        </td>
                        <td>
                          <?= $form->field($line, "[{$i}]description")->textInput(['maxlength' => true])->label(false) ?>

                        </td>
                        <td>
                           <?= $form->field($line, "[{$i}]quantity")->textInput(['maxlength' => true, 'onchange'=>'getTotal($(this))', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                        </td>
                        <td>
                          <?= $form->field($line, "[{$i}]unit_price")->textInput(['maxlength' => true,'onchange'=>'getTotal($(this))', 'placeholder'=>'0.00','style'=>'text-align:right' ])->label(false) ?>
                        </td>
                        <td>
                          <?= $form->field($line, "[{$i}]total_amount_text")->textInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                          <?= $form->field($line, "[{$i}]total_amount")->hiddenInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control sumPart', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>

                        </td>

                  </tr>
                <?php endforeach; ?>

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
                        <?php $form->field($line, "[{$i}]category")->textInput(['maxlength' => true])->label(false) ?>
                        <?= $form->field($line, "[{$i}]category")->dropDownList($cat,['prompt'=>'Please Select'])->label(false) ?>

                      </td>

                      <td>
                        <?= $form->field($line, "[{$i}]item_code")->textInput(['maxlength' => true])->label(false) ?>
                      </td>
                      <td>
                        <?= $form->field($line, "[{$i}]description")->textInput(['maxlength' => true])->label(false) ?>

                      </td>
                      <td>
                         <?= $form->field($line, "[{$i}]quantity")->textInput(['maxlength' => true, 'onchange'=>'getTotal($(this))', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                      </td>
                      <td>
                        <?= $form->field($line, "[{$i}]unit_price")->textInput(['maxlength' => true,'onchange'=>'getTotal($(this))', 'placeholder'=>'0.00','style'=>'text-align:right' ])->label(false) ?>
                      </td>
                      <td>
                        <?= $form->field($line, "[{$i}]total_amount_text")->textInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                        <?= $form->field($line, "[{$i}]total_amount")->hiddenInput(['maxlength' => true,'readOnly'=>true, 'class'=>'form-control sumPart', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>

                      </td>

                </tr>
              <?php endforeach; ?>

            <?php endif; ?>



            </table>
            <table class="table" style="margin-bottom: -15px;">
              <tr>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:25%;border-top:0px">
                  <?= $form->field($model, 'payment')->dropDownList($payments,['prompt'=>'Select Payment Method'])->label(false) ?>
                </td>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:25%;border-top:0px"></td>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:10%; vertical-align:middle; text-align:right;border-top:0px">
                  <label>SubTotal</label>
                </td>
                <td style="width:10%;border-top:0px">
                  <?= $form->field($model, 'subtotal')->textInput(['readonly'=>true, 'placeholder'=>0.00,  'style'=>'text-align:right'])->label(false) ?>
                </td>
              </tr>
              <tr>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:25%;border-top:0px"></td>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:25%;border-top:0px"></td>
                <td style="width:10%;border-top:0px;vertical-align:middle; text-align:right;border-top:0px" colspan="2">
                  <label>Delivery Charge</label>
                </td>
                <td style="width:10%; vertical-align:middle; text-align:right;border-top:0px">
                  <?= $form->field($model, 'charge')->textInput(['maxlength' => true, 'onchange'=>'getGrandTotal()','style'=>'text-align:right'])->label(false) ?>
                </td>

              </tr>
              <tr>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:25%;border-top:0px"> </td>
                <td style="width:10%;border-top:0px"></td>
                <td style="width:25%;border-top:0px"></td>
                <td style="width:10%;border-top:0px;vertical-align:middle; text-align:right;border-top:0px" colspan="2">
                  <label>Grand Total</label>
                </td>
                <td style="width:10%; vertical-align:middle; text-align:right;border-top:0px">
                  <?= $form->field($model, 'grand_total')->textInput(['readonly'=>true, 'placeholder'=>0.00, 'style'=>'text-align:right'])->label(false) ?>                </td>
              </tr>
            </table>


              </div>

          </div>
      <?php DynamicFormWidget::end(); ?>


    <!--Dynamic table ends here------->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?php if (!$model->isNewRecord): ?>
            <?= Html::a(' Print DO', ['offline-order/print-do', 'id'=>$model->id], ['class' => 'btn btn-default','target'=>'_blank']) ?>
            <?= Html::a(' Print Invoice', ['offline-order/print-inv', 'id'=>$model->id], ['class' => 'btn btn-default','target'=>'_blank']) ?>
            <?= Html::a('Print DO+Inv', ['offline-order/print-dinv', 'id'=>$model->id], ['class' => 'btn btn-default','target'=>'_blank']) ?>

        <?php endif; ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
  Modal::begin([
    'header'=>'Gift To',
    'id'=>'modals',
    'size'=>'modal-lg',
    //'clientOptions' => ['backdrop' => false],
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal" id="mclose" onclick="mclose()">Add message</a> ',
  //  'closeButton'=>'tag',
  ]);

 ?>

<div class="" id="modalContent">

</div>

<?php Modal::end() ?>
