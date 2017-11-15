<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property string $model
 * @property string $sku
 * @property string $upc
 * @property string $ean
 * @property string $jan
 * @property string $isbn
 * @property integer $mpn
 * @property string $location
 * @property integer $quantity
 * @property integer $stock_status_id
 * @property string $image
 * @property string $image_feature
 * @property integer $manufacturer_id
 * @property integer $shipping
 * @property string $price
 * @property integer $points
 * @property integer $tax_class_id
 * @property string $date_available
 * @property string $weight
 * @property integer $weight_class_id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $length_class_id
 * @property integer $subtract
 * @property integer $minimum
 * @property integer $sort_order
 * @property integer $status
 * @property integer $viewed
 * @property string $date_added
 * @property string $date_modified
 * @property string $mfilter_tags
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location', 'stock_status_id', 'image_feature', 'manufacturer_id', 'tax_class_id', 'date_added', 'date_modified', 'mfilter_tags'], 'required'],
            [['mpn', 'quantity', 'stock_status_id', 'manufacturer_id', 'shipping', 'points', 'tax_class_id', 'weight_class_id', 'length_class_id', 'subtract', 'minimum', 'sort_order', 'status', 'viewed'], 'integer'],
            [['price', 'weight', 'length', 'width', 'height'], 'number'],
            [['date_available', 'date_added', 'date_modified'], 'safe'],
            [['mfilter_tags'], 'string'],
            [['model', 'sku'], 'string', 'max' => 64],
            [['upc'], 'string', 'max' => 12],
            [['ean'], 'string', 'max' => 14],
            [['jan'], 'string', 'max' => 13],
            [['isbn'], 'string', 'max' => 17],
            [['location'], 'string', 'max' => 128],
            [['image', 'image_feature'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'model' => 'Model',
            'sku' => 'Sku',
            'upc' => 'Upc',
            'ean' => 'Ean',
            'jan' => 'Jan',
            'isbn' => 'Isbn',
            'mpn' => 'Mpn',
            'location' => 'Location',
            'quantity' => 'Quantity',
            'stock_status_id' => 'Stock Status ID',
            'image' => 'Image',
            'image_feature' => 'Image Feature',
            'manufacturer_id' => 'Manufacturer ID',
            'shipping' => 'Shipping',
            'price' => 'Price',
            'points' => 'Points',
            'tax_class_id' => 'Tax Class ID',
            'date_available' => 'Date Available',
            'weight' => 'Weight',
            'weight_class_id' => 'Weight Class ID',
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'length_class_id' => 'Length Class ID',
            'subtract' => 'Subtract',
            'minimum' => 'Minimum',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'viewed' => 'Viewed',
            'date_added' => 'Date Added',
            'date_modified' => 'Date Modified',
            'mfilter_tags' => 'Mfilter Tags',
        ];
    }
}
