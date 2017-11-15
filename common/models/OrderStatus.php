<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_status".
 *
 * @property integer $order_status_id
 * @property integer $language_id
 * @property string $name
 */
class OrderStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'name'], 'required'],
            [['language_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_status_id' => 'Order Status ID',
            'language_id' => 'Language ID',
            'name' => 'Name',
        ];
    }
}
