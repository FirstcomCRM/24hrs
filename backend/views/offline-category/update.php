<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineCategory */

$this->title = 'Update Offline Category: '.$model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Offline Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offline-category-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
