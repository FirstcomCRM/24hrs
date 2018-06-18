<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DeliveryTime */

$this->title = 'Create Standard Delivery Time';
//$this->params['breadcrumbs'][] = ['label' => 'Delivery Time', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-time-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
