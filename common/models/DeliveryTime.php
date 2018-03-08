<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery_time".
 *
 * @property int $id
 * @property string $delivery_time
 */
class DeliveryTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_time'], 'required'],
            [['delivery_time'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_time' => 'Delivery Time',
        ];
    }
}
