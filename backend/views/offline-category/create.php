<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OfflineCategory */

$this->title = 'Create Offline Category';
$this->params['breadcrumbs'][] = ['label' => 'Offline Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offline-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
