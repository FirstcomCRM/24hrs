<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offline_category".
 *
 * @property int $id
 * @property string $off_category Item Category for Offline
 */
class OfflineCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['off_category'], 'required'],
            [['off_category'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'off_category' => 'Off Category',
        ];
    }
}
