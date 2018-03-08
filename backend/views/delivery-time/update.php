<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DeliveryTime */

$this->title = 'Update Delivery Time: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Time', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="delivery-time-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
