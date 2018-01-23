<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Product;
use common\models\OrderProduct;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Management System';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?php Html::encode($this->title) ?></h1>

    <div class="current-time well well-sm">
      <h4> Current Date/Time: <?php echo date('Y-m-d') ?> <span id=time></span></h4>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
          <?php echo  $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body"> <!--Start of the panel body for the Lists-->
        <ul class="nav nav-tabs">
          <li class="active"> <a href="#today" data-toggle="tab">Pending Orders for Today</a></li>
          <li> <a href="#future" data-toggle="tab"> Pending Future Orders</a></li>
          <li> <a href="#completed" data-toggle="tab"> Orders Done</a></li>
        </ul>

        <br>
        <div class="tab-content">
          <div class="tab-pane fade in active" id="today"> <!--Start of Pending Orders for Today-->
            <div class="table-responsive">
              <?php Pjax::begin(['timeout' => 10000 ]); ?>
                <?= GridView::widget([
                      'dataProvider' => $dataProvider,
                    //  'filterModel' => $searchModel,
                      'columns' => [
                          ['class' => 'yii\grid\SerialColumn'],


                          [
                            'attribute'=>'delivery_date',
                            'value'=>'orderProduct.delivery_date',
                          ],
                          [
                            'attribute'=>'delivery_text_time',
                            'label'=>'Delivery Time',
                            'value'=>'orderProduct.delivery_text_time',
                          ],
                            'order_id',
                            'invoice_no',

                          [
                            'attribute'=>'orderProduct.product_id',
                            'label'=>'Product Code',
                            'value'=>'orderProduct.product_id',
                          ],

                         [
                            'attribute'=>'image',
                            'label'=>'Image',
                            'format'=>'raw',
                            'value'=>function($model){
                                $data = OrderProduct::find()->where(['order_id'=>$model->order_id])->one();
                                if (!empty($data)) {
                                    $pdata = Product::find()->where(['product_id'=>$data->product_id])->one();
                                }else{
                                  return $data = null;
                                }

                                if (!empty($pdata) ) {
                                  $path = Yii::getAlias('@image').'/'.$pdata->image;
                                  return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
                                }else{
                                  return $pdata = null;
                                }

                            },
                          ],

                        [
                          'header'=>'Action',
                          'class'=>'yii\grid\ActionColumn',
                          'template'=>'{email}{complete}',
                          'options'=>['style'=>'padding:20px'],
                          'buttons'=>[
                            'email'=>function($url,$model,$key){
                                //return Html::a('<i class="fa fa-envelope-open-o" aria-hidden="true"></i>');
                                //  return Html::a('<i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>', ['email','id'=>$key], ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button','onclick'=>'myEmail()']);
                                  return Html::a('<i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>', '#', ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button',
                                  'onclick'=>'myEmail('.$model->order_id .')']);

                            },
                            'complete'=>function($url,$model,$key){
                              return Html::a('<i class="fa fa-check fa-2x" aria-hidden="true"></i>', ['complete', 'id'=>$key], ['title'=>'Complete Order','data-pjax'=>0]);
                            }
                          ],
                        ],

                      ],
                  ]); ?>
              <?php Pjax::end(); ?>
            </div>
          </div><!--End of Pending Orders for Today-->

          <div class="tab-pane fade" id="future"><!--Start of Pending Future Order-->
            <div class="table-responsive">
              <?php Pjax::begin(['timeout' => 10000 ]); ?>
                <?= GridView::widget([
                      'dataProvider' => $dataProvider_future,

                    //  'filterModel' => $searchModel,
                      'columns' => [
                          ['class' => 'yii\grid\SerialColumn'],

                          [
                            'attribute'=>'delivery_date',
                            'value'=>'orderProduct.delivery_date',
                          ],
                          [
                            'attribute'=>'delivery_text_time',
                            'label'=>'Delivery Time',
                            'value'=>'orderProduct.delivery_text_time',
                          ],
                            'order_id',
                            'invoice_no',
                          [

                            'attribute'=>'orderProduct.product_id',
                            'label'=>'Product Code',
                            'value'=>'orderProduct.product_id',

                          ],

                          [
                             'attribute'=>'image',
                             'label'=>'Image',
                             'format'=>'raw',
                             'value'=>function($model){
                                 $data = OrderProduct::find()->where(['order_id'=>$model->order_id])->one();
                                 if (!empty($data)) {
                                   $pdata = Product::find()->where(['product_id'=>$data->product_id])->one();
                                 }else{
                                   return $data = null;
                                 }

                                 if (!empty($pdata) ) {
                                   $path = Yii::getAlias('@image').'/'.$pdata->image;
                                   return '<a href="'.$path.'" data-pjax=0 "><img style="width:50px;" src="'.$path.'"></a>';
                                 }else{
                                   return $pdata = null;
                                 }

                             },
                           ],

                        [
                          'header'=>'Action',
                          'class'=>'yii\grid\ActionColumn',
                          'template'=>'{email}{complete}',
                          'options'=>['style'=>'padding:20px'],
                          'buttons'=>[
                            'email'=>function($url,$model,$key){
                                  return Html::a('<i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>', '#', ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button',
                                  'onclick'=>'myEmail('.$model->order_id .')']);
                            },
                            'complete'=>function($url,$model,$key){
                              return Html::a('<i class="fa fa-check fa-2x" aria-hidden="true"></i>', ['complete', 'id'=>$key], ['title'=>'Complete Order','data-pjax'=>0]);
                            }
                          ],
                        ],


                      ],
                  ]); ?>
              <?php Pjax::end(); ?>
            </div>
          </div><!--End of Pending Future Order-->

          <div class="tab-pane fade" id="completed"><!--Start of Orders Done-->

                <?php Pjax::begin(['timeout' => 18000 ]); ?>
                  <?= GridView::widget([
                        'dataProvider' => $dataProvider_done,
                        //  'layout'=>"{items}\n{pager}",
                      //  'filterModel' => $searchModel,
                        'columns' => [
                          ['class' => 'yii\grid\SerialColumn'],

                          [
                            'attribute'=>'delivery_date',
                            'value'=>'orderProduct.delivery_date',
                          ],
                          [
                            'attribute'=>'delivery_text_time',
                            'label'=>'Delivery Time',
                            'value'=>'orderProduct.delivery_text_time',
                          ],
                            'order_id',
                            'invoice_no',

                            [
                              'attribute'=>'product_id',
                            //  'value'=>'orderProduct.product_id',
                              'format'=>'raw',
                              'value'=>function($model){
                                  $prods = '';
                                  $data = OrderProduct::find()->where(['order_id'=>$model->order_id])->asArray()->all();
                                  foreach ($data as $key => $value) {
                                    $prods .= $value['product_id'].'<br>';
                                  }
                                  return $prods;
                              },
                            ],

                            [
                              'attribute'=>'test',
                              'format'=>'raw',
                              'value'=>function($model){
                                return $this->render('tests',['model' => $model]);
                              },
                            ],

                          [
                            'header'=>'Action',
                            'class'=>'yii\grid\ActionColumn',
                            'template'=>'{email}',
                            'options'=>['style'=>'padding:20px'],
                            'buttons'=>[
                              'email'=>function($url,$model,$key){
                                    return Html::a('<i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>', false, ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button',
                                    'onclick'=>'myEmail('.$model->order_id .')']);

                              },
                            ],
                          ],

                        ],
                    ]); ?>
                <?php Pjax::end(); ?>

          </div><!--End of Orders Done-->

        </div>

      </div> <!--End of the panel body for the Lists-->
    </div>



</div>

<?php
$script = <<< JS
$(document).ready(function() {

  var myVar = setInterval(function(){ myTimer() }, 1000);

  function myTimer() {
      var d = new Date();
      var t = d.toLocaleTimeString();
      document.getElementById("time").innerHTML = t;
  }
});
JS;
$this->registerJs($script);
?>
