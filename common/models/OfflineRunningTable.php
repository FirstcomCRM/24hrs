<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offline_running_table".
 *
 * @property integer $id
 * @property integer $value
 * @property string $prefix
 */
class OfflineRunningTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_running_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['prefix'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'prefix' => 'Prefix',
        ];
    }
}
