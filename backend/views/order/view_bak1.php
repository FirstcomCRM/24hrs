<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'order_source',
            'invoice_no',
            'invoice_prefix',
            'store_id',
            'store_name',
            'store_url:url',
            'customer_id',
            'customer_group_id',
            'firstname',
            'lastname',
            'email:email',
            'telephone',
            'shipping_telephone',
            'fax',
            'custom_field:ntext',
            'payment_firstname',
            'payment_lastname',
            'payment_company',
            'payment_address_1',
            'payment_address_2',
            'payment_city',
            'payment_postcode',
            'payment_country',
            'payment_country_id',
            'payment_zone',
            'payment_zone_id',
            'payment_address_format:ntext',
            'payment_custom_field:ntext',
            'payment_method',
            'payment_code',
            'shipping_firstname',
            'shipping_lastname',
            'shipping_company',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_city',
            'shipping_postcode',
            'shipping_country',
            'shipping_country_id',
            'shipping_zone',
            'shipping_zone_id',
            'shipping_address_format:ntext',
            'shipping_custom_field:ntext',
            'shipping_method',
            'shipping_code',
            'comment:ntext',
            'total',
            'order_status_id',
            'affiliate_id',
            'commission',
            'marketing_id',
            'tracking',
            'language_id',
            'currency_id',
            'currency_code',
            'currency_value',
            'ip',
            'forwarded_ip',
            'user_agent',
            'accept_language',
            'date_added',
            'date_modified',
            'date_invoice',
        ],
    ]) ?>

</div>
