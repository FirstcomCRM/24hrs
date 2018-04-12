<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jgmg". Also known as occassional messages
 *
 * @property int $gmg_id
 * @property int $gmg_seqno
 * @property string $gmg_message
 * @property string $gmg_occ
 * @property int $insertBy
 * @property string $insertDateTime
 * @property int $updateBy
 * @property string $updateDateTime
 */
class Jgmg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jgmg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['gmg_seqno', 'gmg_message', 'gmg_occ', 'insertBy', 'insertDateTime', 'updateBy', 'updateDateTime'], 'required'],
            [['gmg_seqno', 'insertBy', 'updateBy'], 'integer'],
            [['gmg_message', 'gmg_occ'], 'string'],
            [['insertDateTime', 'updateDateTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gmg_id' => 'Gmg ID',
            'gmg_seqno' => 'Gmg Seqno',
            'gmg_message' => 'Gmg Message',
            'gmg_occ' => 'Gmg Occ',
            'insertBy' => 'Insert By',
            'insertDateTime' => 'Insert Date Time',
            'updateBy' => 'Update By',
            'updateDateTime' => 'Update Date Time',
        ];
    }
}
