<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OfflineCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offline Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Offline Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'off_category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
