<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\OfflineOrderProduct;
use common\models\OrderProduct;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OfflineOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offline Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-index">


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body">
        <p class="text-right">
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
              //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                //    'id',
                    'invoice_no',
                    [
                      'attribute'=>'invoice_date',
                      'format' => ['date', 'php:d M Y']
                    ],
                    [
                      'attribute'=>'delivery_date',
                      'format' => ['date', 'php:d M Y']
                    ],
                    'customer_name',
                    ['class' => 'yii\grid\ActionColumn'],

                ],
            ]); ?>
      </div>
    </div>

    <?php Pjax::end(); ?>
</div>
