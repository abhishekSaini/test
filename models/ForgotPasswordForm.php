<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * ForgotPasswordForm is the model behind the ForgotPassword form.
 */
class ForgotPasswordForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetAttribute' => 'email', 'targetClass' => 'app\models\User']
        ];
    }

    public function sendForgotPasswordEmail($user) {
      
      Yii::$app->mailer->compose('forgotPassword', ['user' => $user])
        ->setFrom(Yii::$app->params['fromEmail'])
        ->setTo($user->email)
        ->setSubject('Password Reset requested')
        ->send();
    }
}
