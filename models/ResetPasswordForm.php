<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * ForgotPasswordForm is the model behind the ForgotPassword form.
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $cPassword;
    public $id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'cPassword'], 'required'],
            ['cPassword', 'compare', 'compareAttribute' => 'password'],
            ['id', 'exist', 'targetAttribute' => 'authKey', 'targetClass' => 'app\models\User', 'message' => 'Invalid token specified.' ]
        ];
    }
    
    public function attributeLabels() {
      
      return [
          'cPassword' => 'Confirm Password'
      ];
    }
}
