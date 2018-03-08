<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DeliveryTimeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery Time';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-time-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <p>
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                'delivery_time:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>


</div>
