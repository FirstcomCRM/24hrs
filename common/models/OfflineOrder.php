<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offline_order".
 *
 * @property int $id
 * @property string $invoice_no order-table(invoice_prefix)
 * @property string $invoice_date order-table(date_invoice)
 * @property string $delivery_date order-product(delivery_date)
 * @property string $customer_name order-table(firstname, lastname)
 * @property string $email order-table(email)
 * @property string $contact_number order-table(telephone)
 * @property string $recipient_name order-table(payment_firstname,payment_lastname)
 * @property string $recipient_contact_num NA???
 * @property string $recipient_address order-table(payment_address)
 * @property string $recipient_email NA???
 * @property string $recipient_postal_code
 * @property string $recipient_country
 */
class OfflineOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_date', 'delivery_date', 'customer_name', 'email', 'contact_number', 'recipient_name','delivery_time', 'recipient_contact_num', 'recipient_address', 'recipient_email', 'recipient_postal_code', 'recipient_country'], 'required'],
            [['invoice_date', 'delivery_date'], 'safe'],
            [['email','recipient_email'],'email'],
            [['status'],'integer'],
            [['recipient_address'], 'string'],
            [['invoice_no', 'contact_number', 'recipient_contact_num', 'recipient_postal_code'], 'string', 'max' => 25],
            [['customer_name'], 'string', 'max' => 100],
            [['email', 'recipient_name', 'recipient_email','delivery_time'], 'string', 'max' => 75],
            [['recipient_country'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_no' => 'Invoice No',
            'invoice_date' => 'Invoice Date',
            'delivery_date' => 'Delivery Date',
            'customer_name' => 'Customer Name',
            'delivery_time'=>'Delivery Time',
            'email' => 'Email',
            'contact_number' => 'Contact Number',
            'recipient_name' => 'Recipient Name',
            'recipient_contact_num' => 'Recipient Contact Number',
            'recipient_address' => 'Recipient Address',
            'recipient_email' => 'Recipient Email',
            'recipient_postal_code' => 'Recipient Postal Code',
            'recipient_country' => 'Recipient Country',
            'Status'=>'Status',
        ];
    }

    public function getOfflineProduct(){
      return $this->hasOne(OfflineOrderProduct::className(),['off_order_id' => 'id'] );
      //return $this->hasMany(OrderProduct::className(),['order_id' => 'order_id'] );
    }

    public function getOfflineStatus(){
        return $this->hasOne(OrderStatus::className(),['order_status_id' => 'status'] );
    }
}