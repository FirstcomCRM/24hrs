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
            [['invoice_date', 'delivery_date','payment', 'customer_name', 'contact_number', 'recipient_name','recipient_contact_num', 'recipient_address', 'recipient_postal_code','charge'], 'required'],
            [['invoice_date', 'delivery_date','delivery_time_start','delivery_time_end'], 'safe'],
            [['email'],'email'],
            [['status','payment','off_detect','contact_number', 'recipient_contact_num','delivery_trigger'	],'integer'],
            [['charge'],'number'],
            [['subtotal', 'grand_total'],'number','numberPattern' => '/^\s*[-+]?[0-9\,]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['recipient_address','remarks'], 'string'],
            [['gift_message'],'string','max'=>150],
            [['invoice_no', 'recipient_postal_code','delivery_time'], 'string', 'max' => 25],
            [['customer_name'], 'string', 'max' => 100],
            [['email', 'recipient_name'], 'string', 'max' => 75],
            [['recipient_country'], 'string', 'max' => 50],
            [['gift_to','gift_from','taken_by','recipient_email'], 'string', 'max' => 75],
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
            'Delivery Trigger'=> 'Delivery Trigger',
            'delivery_time'=>'Standard Delivery Time',
            'delivery_time_start'=>'Special Time Start',
            'delivery_time_end'=>'Special Time End',
            'email' => 'Email',
            'contact_number' => 'Contact Number',
            'remarks'=>'Remarks',
            'recipient_name' => 'Recipient Name',
            'recipient_contact_num' => 'Recipient Contact Number',
            'recipient_address' => 'Recipient Address',
            'recipient_email' => 'Recipient Email',
            'recipient_postal_code' => 'Recipient Postal Code',
        //    'recipient_country' => 'Recipient Country',
            'Status'=>'Status',
            'charge'=>'Delivery Charge',
            'payment'=>'Payment Method',
            'gift_to'=>'Gift To',
            'gift_from'=>'Gift From',
            'gift_message'=>'Gift Message',
            'taken_by'=>'Taken By',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
          //  $this->final_sales_price = str_replace(",", "", $this->final_sales_price);
            $this->subtotal = str_replace(",", "", $this->subtotal);
            $this->grand_total= str_replace(",", "", $this->grand_total);

            if ($this->delivery_trigger == 1) {
              $this->delivery_time = $this->delivery_time_start.' - '.$this->delivery_time_end;
            }

            $inv = new \DateTime($this->invoice_date);
            $this->invoice_date = $inv->format('Y-m-d');

            $del = new \DateTime($this->delivery_date);
            $this->delivery_date = $del->format('Y-m-d');

            $this->delivery_time_start = date('H:i:s',strtotime($this->delivery_time_start) );
            $this->delivery_time_end = date('H:i:s',strtotime($this->delivery_time_end) );
            $this->recipient_email = 'blank@blank.test';
          
            return true;
        } else {
            return false;
        }
    }

    public function getOfflineProduct(){
      return $this->hasOne(OfflineOrderProduct::className(),['off_order_id' => 'id'] );
      //return $this->hasMany(OrderProduct::className(),['order_id' => 'order_id'] );
    }

    public function getOfflineStatus(){
        return $this->hasOne(OrderStatus::className(),['order_status_id' => 'status'] );
    }
}
