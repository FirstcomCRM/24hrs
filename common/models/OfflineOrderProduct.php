<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offline_order_product".
 *
 * @property int $id order-product(order-product-di)
 * @property int $off_order_id order-product(order_id)
 * @property int $item_code order-product(product_id)
 * @property int $quantity order-product(quantity)
 * @property string $unit_price order-product(price)
 * @property string $total_amount order-product(total)
 * @property string $del_date order-product(delivery_date)
 * @property string $del_time order-product(delivery_text_time)
 */
class OfflineOrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_order_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_code', 'quantity', 'unit_price'], 'required'],
            [['off_order_id', 'item_code', 'quantity'], 'integer'],
            [['unit_price', 'total_amount'], 'number'],
            [['del_date'], 'safe'],
            [['del_time'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'off_order_id' => 'Off Order ID',
            'item_code' => 'Item Code',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total_amount' => 'Total Amount',
            'del_date' => 'Del Date',
            'del_time' => 'Del Time',
        ];
    }
}
