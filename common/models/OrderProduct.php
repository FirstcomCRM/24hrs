<?php

namespace common\models;

use Yii;
//use common\models\Product
/**
 * This is the model class for table "order_product".
 *
 * @property integer $order_product_id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $name
 * @property string $model
 * @property integer $quantity
 * @property string $price
 * @property string $total
 * @property string $tax
 * @property integer $reward
 * @property string $gift_to
 * @property string $gift_message_comment
 * @property string $gift_from
 * @property string $delivery_date
 * @property string $delivery_time
 * @property string $delivery_text_time
 * @property string $delivery_amount
 * @property string $collection_date
 * @property string $collection_time
 * @property string $collection_text_time
 * @property string $collection_amount
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $sp_start;
    public $sp_end;
    public $standard_time;
    public $delivery_trigger;

    public static function tableName()
    {
        return 'order_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['order_id', 'product_id', 'name', 'model', 'quantity', 'reward', 'gift_to', 'gift_message_comment', 'gift_from', 'delivery_date', 'delivery_time', 'delivery_text_time', 'delivery_amount', 'collection_date', //'collection_time', 'collection_text_time', 'collection_amount'], 'required'],
            [['order_id', 'product_id', 'quantity', 'reward'], 'integer'],
            [['price', 'total', 'tax', 'delivery_amount', 'collection_amount'], 'number'],
            [['gift_message_comment','sp_start','sp_end','standard_time','delivery_trigger'], 'string'],
            [['delivery_date', 'collection_date'], 'safe'],
            [['name', 'gift_to', 'gift_from', 'delivery_time', 'delivery_text_time', 'collection_time', 'collection_text_time'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_product_id' => 'Order Product ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'model' => 'Model',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'total' => 'Total',
            'tax' => 'Tax',
            'reward' => 'Reward',
            'gift_to' => 'Gift To',
            'gift_message_comment' => 'Gift Message Comment',
            'gift_from' => 'Gift From',
            'delivery_date' => 'Delivery Date',
            'delivery_time' => 'Delivery Time',
            'delivery_text_time' => 'Delivery Text Time',
            'delivery_amount' => 'Delivery Amount',
            'collection_date' => 'Collection Date',
            'collection_time' => 'Collection Time',
            'collection_text_time' => 'Collection Text Time',
            'collection_amount' => 'Collection Amount',
            'sp_end'=>'Special End Time',
            'sp_start'=>'Special Start Time',
            'standard_time'=>'Standard Time',
        ];
    }

    public function getProduct(){
      return $this->hasOne(Product::className(),['product_id' => 'product_id'] );
  //    return $this->has(Product::className(),['product_id' => 'product_id'] );
    }
}
