<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OfflineCategory */

$this->title = 'Create Offline Category';
//$this->params['breadcrumbs'][] = ['label' => 'Offline Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
