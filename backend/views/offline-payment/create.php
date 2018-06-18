<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OfflinePayment */

$this->title = 'Create Payment';
//$this->params['breadcrumbs'][] = ['label' => 'Offline Payments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
