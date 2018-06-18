<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OfflinePayment */

$this->title = 'Update Payment:'.$model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Offline Payments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offline-payment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
