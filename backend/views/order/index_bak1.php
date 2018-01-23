<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\models\Product;
use common\models\OrderProduct;
use common\models\OfflineOrderProduct;
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


    <div class="panel panel-warning">
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

                      // /    'id',
                        [
                          'attribute'=>'id',
                          'label'=>'Order ID',
                        ],

                        [
                          'attribute'=>'del_date',
                          'label'=>'Delivery Date',
                        ],
                        [
                          'attribute'=>'del_time',
                          'label'=>'Delivery Time',
                        ],

                        'invoice_no',
                        [
                          'attribute'=>'invoice_date',
                          'format' => ['date', 'php:Y-m-d']
                        ],
                        [
                          'attribute'=>'item_code',
                          'format'=>'raw',
                          'value'=>function($model){
                              $prods = '';
                              if ($model['invoice_no']!= '0') {
                                $data = OfflineOrderProduct::find()->where(['off_order_id'=>$model['id'] ])->asArray()->all();
                                foreach ($data as $key => $value) {
                                  $prods .= $value['item_code'].'<br>';
                                }
                              }else{
                                $data = OrderProduct::find()->where(['order_id'=>$model['id'] ])->asArray()->all();
                                foreach ($data as $key => $value) {
                                  $prods .= $value['product_id'].'<br>';
                                }
                              }

                              return $prods;
                          },
                        ],

                         /*[
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
                          ],*/

                        [
                          'header'=>'Action',
                          'class'=>'yii\grid\ActionColumn',
                          'template'=>'{view} {update}{email}{complete}',

                          'options'=>['style'=>'padding:20px'],
                          'buttons'=>[
                            'view'=>function($url,$model, $key){
                              return Html::a(' <i class="fa fa-eye fa-lg" aria-hidden="true"></i>', $url, ['id' => $model['id'], 'title' => Yii::t('app', 'View'),'data-pjax'=>0,
                              ]);
                            },
                            'update'=>function($url,$model){
                              return Html::a(' <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>',$url,['id'=>$model['id'], 'title'=>Yii::t('app','Update'),'data-pjax'=>0,
                              ]);
                            },
                            'email'=>function($url,$model,$key){
                                  return Html::a('<i class="fa fa-envelope-open-o " aria-hidden="true"></i>', '#', ['title'=>'Email to customer','data-pjax'=>0,'class'=>'email-button',
                                  'onclick'=>'myEmail('.$model['id'] .')']);

                            },
                            'complete'=>function($url,$model,$key){
                              return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['complete', 'id'=>$model['id']], ['title'=>'Complete Order','data-pjax'=>0]);
                            }
                          ],
                          'visibleButtons'=>[
                            'view'=> function($model){
                              return $model['invoice_no'] !='0';
                            },
                            'update'=>function($model){
                                return $model['invoice_no'] !='0';
                            },
                          ],
                          'urlCreator'=> function($action,$model,$key,$index){
                            if ($action ==='view'){
                              //$url = '?r=offline-order%2Fview&id='.$model['id'];
                              $url = Url::to(['offline-order/view', 'id'=>$model['id']]);
                              return $url;
                            }
                            if ($action==='update') {
                              //$url = '?r=offline-order%2Fupdate&id='.$model['id'];
                              $url = Url::to(['offline-order/update', 'id'=>$model['id']]);
                              return $url;
                            }

                          }


                        ],

                      ],
                  ]); ?>
              <?php Pjax::end(); ?>
            </div>
          </div><!--End of Pending Orders for Today-->

          <div class="tab-pane fade" id="future"><!--Start of Pending Future Order-->
            test
          </div><!--End of Pending Future Order-->

          <div class="tab-pane fade" id="completed"><!--Start of Orders Done-->
            test1


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
