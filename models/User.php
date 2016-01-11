<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
  
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'last_name', 'email', 'last_name', 'type', 'status'], 'required'],
            ['password', 'required', 'on' => 'create'],
            ['email', 'unique'],
            ['email', 'email'],
            ['password', 'safe'],
        ];
    }    

    public static function tableName()
    {
       return 'user';
    }
    
    /**
      * @inheritdoc
      */
    public static function findIdentity($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }*/

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        
      return self::find()->where(['username' => $username])->one();
    }
    
    public static function findByEmail($email)
    {
        
      return self::find()->where(['email' => $email])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    
    public static function getStatusList() {
      
      return [
          '1' => 'Active',
          '0' => 'Inactive'
      ];
    }
    
    
    //convert password to md5
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            
            if($insert)
              $this->password = md5($this->password);
            else {
              
              if($this->password)
                $this->password = md5($this->password);
              else {
               
                $user = static::find()->where(['email' => $this->email])->one();
                $this->password = $user->password;
              }
            }

            return true;
        } else {
            return false;
        }
    }    
}
