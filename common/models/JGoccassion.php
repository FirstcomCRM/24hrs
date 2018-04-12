<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "j_goccassion". Also known as list of occassions
 *
 * @property int $occassion_id
 * @property string $occassion_text
 * @property int $insertBy
 * @property string $insertDateTime
 * @property int $updateBy
 * @property string $updateDateTime
 */
class JGoccassion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j_goccassion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['occassion_text', 'insertBy', 'insertDateTime', 'updateBy', 'updateDateTime'], 'required'],
            [['occassion_text'], 'string'],
            [['insertBy', 'updateBy'], 'integer'],
            [['insertDateTime', 'updateDateTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'occassion_id' => 'Occassion ID',
            'occassion_text' => 'Occassion Text',
            'insertBy' => 'Insert By',
            'insertDateTime' => 'Insert Date Time',
            'updateBy' => 'Update By',
            'updateDateTime' => 'Update Date Time',
        ];
    }
}
