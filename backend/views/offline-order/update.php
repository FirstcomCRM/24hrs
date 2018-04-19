<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

$this->title = 'Update Offline Order: '.$model->invoice_no;
//$this->params['breadcrumbs'][] = ['label' => 'Offline Orders', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->invoice_no, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offline-order-update">



    <?= $this->render('_form', [
        'model' => $model,
        'modelLine'=> $modelLine,
    ]) ?>

</div>
