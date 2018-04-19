<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class EmailForm extends Model
{
    public $email;
    public $title;
    public $cc;
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['email', 'title','message'], 'required'],
          //  [['cc'],'string'],
            [['email'],'email'],

        ];
    }


}
