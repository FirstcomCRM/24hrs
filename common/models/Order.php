<?php

namespace common\models;

use Yii;
use common\models\OrderProduct;
use common\models\OrderStatus;
/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property string $order_source
 * @property integer $invoice_no
 * @property string $invoice_prefix
 * @property integer $store_id
 * @property string $store_name
 * @property string $store_url
 * @property integer $customer_id
 * @property integer $customer_group_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $telephone
 * @property string $shipping_telephone
 * @property string $fax
 * @property string $custom_field
 * @property string $payment_firstname
 * @property string $payment_lastname
 * @property string $payment_company
 * @property string $payment_address_1
 * @property string $payment_address_2
 * @property string $payment_city
 * @property string $payment_postcode
 * @property string $payment_country
 * @property integer $payment_country_id
 * @property string $payment_zone
 * @property integer $payment_zone_id
 * @property string $payment_address_format
 * @property string $payment_custom_field
 * @property string $payment_method
 * @property string $payment_code
 * @property string $shipping_firstname
 * @property string $shipping_lastname
 * @property string $shipping_company
 * @property string $shipping_address_1
 * @property string $shipping_address_2
 * @property string $shipping_city
 * @property string $shipping_postcode
 * @property string $shipping_country
 * @property integer $shipping_country_id
 * @property string $shipping_zone
 * @property integer $shipping_zone_id
 * @property string $shipping_address_format
 * @property string $shipping_custom_field
 * @property string $shipping_method
 * @property string $shipping_code
 * @property string $comment
 * @property string $total
 * @property integer $order_status_id
 * @property integer $affiliate_id
 * @property string $commission
 * @property integer $marketing_id
 * @property string $tracking
 * @property integer $language_id
 * @property integer $currency_id
 * @property string $currency_code
 * @property string $currency_value
 * @property string $ip
 * @property string $forwarded_ip
 * @property string $user_agent
 * @property string $accept_language
 * @property string $date_added
 * @property string $date_modified
 * @property string $date_invoice
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        /*    [['order_source', 'invoice_prefix', 'store_name', 'store_url', 'firstname', 'lastname', 'email', 'telephone', 'shipping_telephone', 'fax', 'custom_field', 'payment_firstname', 'payment_lastname', 'payment_company', 'payment_address_1', 'payment_address_2', 'payment_city', 'payment_postcode', 'payment_country', 'payment_country_id', 'payment_zone', 'payment_zone_id', 'payment_address_format', 'payment_custom_field', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_company', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_postcode', 'shipping_country', 'shipping_country_id', 'shipping_zone', 'shipping_zone_id', 'shipping_address_format', 'shipping_custom_field', 'shipping_method', 'shipping_code', 'comment', 'affiliate_id', 'commission', 'marketing_id', 'tracking', 'language_id', 'currency_id', 'currency_code', 'ip', 'forwarded_ip', 'user_agent', 'accept_language', 'date_added', 'date_modified'], 'required'],
*/
            [['invoice_no', 'store_id', 'customer_id', 'customer_group_id', 'payment_country_id', 'payment_zone_id', 'shipping_country_id', 'shipping_zone_id', 'order_status_id', 'affiliate_id', 'marketing_id', 'language_id', 'currency_id'], 'integer'],
            [['custom_field', 'payment_address_format', 'payment_custom_field', 'shipping_address_format', 'shipping_custom_field', 'comment'], 'string'],
            [['total', 'commission', 'currency_value'], 'number'],
            [['date_added', 'date_modified', 'date_invoice'], 'safe'],
            [['order_source', 'currency_code'], 'string', 'max' => 3],
            [['invoice_prefix'], 'string', 'max' => 26],
            [['store_name', 'shipping_telephone', 'tracking'], 'string', 'max' => 64],
            [['store_url', 'user_agent', 'accept_language'], 'string', 'max' => 255],
            [['firstname', 'lastname', 'telephone', 'fax', 'payment_firstname', 'payment_lastname', 'shipping_firstname', 'shipping_lastname'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 96],
            [['payment_company', 'shipping_company', 'ip', 'forwarded_ip'], 'string', 'max' => 40],
            [['payment_address_1', 'payment_address_2', 'payment_city', 'payment_country', 'payment_zone', 'payment_method', 'payment_code', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_country', 'shipping_zone', 'shipping_method', 'shipping_code'], 'string', 'max' => 128],
            [['payment_postcode', 'shipping_postcode'], 'string', 'max' => 10],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_source' => 'Order Source',
            'invoice_no' => 'Invoice No',
            'invoice_prefix' => 'Invoice Prefix',
            'store_id' => 'Store ID',
            'store_name' => 'Store Name',
            'store_url' => 'Store Url',
            'customer_id' => 'Customer ID',
            'customer_group_id' => 'Customer Group ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'telephone' => 'Telephone',
            'shipping_telephone' => 'Shipping Telephone',
            'fax' => 'Fax',
            'custom_field' => 'Custom Field',
            'payment_firstname' => 'Payment Firstname',
            'payment_lastname' => 'Payment Lastname',
            'payment_company' => 'Payment Company',
            'payment_address_1' => 'Payment Address 1',
            'payment_address_2' => 'Payment Address 2',
            'payment_city' => 'Payment City',
            'payment_postcode' => 'Payment Postcode',
            'payment_country' => 'Payment Country',
            'payment_country_id' => 'Payment Country ID',
            'payment_zone' => 'Payment Zone',
            'payment_zone_id' => 'Payment Zone ID',
            'payment_address_format' => 'Payment Address Format',
            'payment_custom_field' => 'Payment Custom Field',
            'payment_method' => 'Payment Method',
            'payment_code' => 'Payment Code',
            'shipping_firstname' => 'Shipping Firstname',
            'shipping_lastname' => 'Shipping Lastname',
            'shipping_company' => 'Shipping Company',
            'shipping_address_1' => 'Shipping Address 1',
            'shipping_address_2' => 'Shipping Address 2',
            'shipping_city' => 'Shipping City',
            'shipping_postcode' => 'Shipping Postcode',
            'shipping_country' => 'Shipping Country',
            'shipping_country_id' => 'Shipping Country ID',
            'shipping_zone' => 'Shipping Zone',
            'shipping_zone_id' => 'Shipping Zone ID',
            'shipping_address_format' => 'Shipping Address Format',
            'shipping_custom_field' => 'Shipping Custom Field',
            'shipping_method' => 'Shipping Method',
            'shipping_code' => 'Shipping Code',
            'comment' => 'Comment',
            'total' => 'Total',
            'order_status_id' => 'Order Status ID',
            'affiliate_id' => 'Affiliate ID',
            'commission' => 'Commission',
            'marketing_id' => 'Marketing ID',
            'tracking' => 'Tracking',
            'language_id' => 'Language ID',
            'currency_id' => 'Currency ID',
            'currency_code' => 'Currency Code',
            'currency_value' => 'Currency Value',
            'ip' => 'Ip',
            'forwarded_ip' => 'Forwarded Ip',
            'user_agent' => 'User Agent',
            'accept_language' => 'Accept Language',
            'date_added' => 'Date Added',
            'date_modified' => 'Date Modified',
            'date_invoice' => 'Date Invoice',
        ];
    }

    public function getOrderProduct(){
      return $this->hasOne(OrderProduct::className(),['order_id' => 'order_id'] );
  //  $test = $this->hasMany(OrderProduct::className(),['order_id' => 'order_id'] );
  //  echo '<pre>';
  //  var_dump(gettype($test));
//    echo '</pre>';die();
      //return $this->hasMany(OrderProduct::className(),['order_id' => 'order_id'] );
    }

    public function getOrderStatus(){
        return $this->hasOne(OrderStatus::className(),['order_status_id' => 'order_status_id'] );
    }
}
