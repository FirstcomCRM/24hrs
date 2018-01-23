<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OfflineOrder */

$this->title = 'Create Offline Order';
$this->params['breadcrumbs'][] = ['label' => 'Offline Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-order-create">



    <?= $this->render('_form', [
        'model' => $model,
        'modelLine'=> $modelLine,
    ]) ?>

</div>
