<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
  
    public $cPassword;
    public $operators;
  
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_updated',
                'value' => function(){ return \Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s'); },
            ],
        ];
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'last_name', 'email', 'last_name', 'type', 'status'], 'required'],
            [['password', 'cPassword'], 'required', 'on' => 'create'],
            ['password', 'compare', 'compareAttribute'=>'cPassword'],
            ['email', 'unique'],
            ['email', 'email'],
            [['password', 'cPassword', 'operators'], 'safe'],
        ];
    }    

    public static function tableName()
    {
       return 'user';
    }
    
    public function attributeLabels() {
      
      return [
          'cPassword' => 'Confirm Password'
      ];
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
        
      return self::find()->where(['email' => $email, 'status' => 1])->one();
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
    
    public function getOperators() {
      
      return $this->hasMany(AdminOperator::className(), ['operator_id' => 'id']);
    }

    public function getAssignedOperators() {
      
      return $this->hasMany(AdminOperator::className(), ['admin_id' => 'id']);
    }
    
    public function getOperatorsName() {
      
      $operatorsId = array_keys(ArrayHelper::map($this->assignedOperators, 'operator_id', 'admin_id'));
      $string = '';
      
      if(!$operatorsId)
        return $string;
      
      $command = \Yii::$app->db->createCommand("SELECT first_name, last_name FROM user WHERE id IN (". implode(',', $operatorsId) .")");
      $data = $command->queryAll();	
      
      foreach ($data as $operator) {
        
        $string .= $operator['first_name'].' '.$operator['last_name'].', ';
      }
      
      return rtrim($string, ', ');
    }
    
    public function afterSave($insert, $changedAttributes) {
      
      parent::afterSave($insert, $changedAttributes);
      
      if($insert) {
        
        if(\Yii::$app->user->identity->type == 'admin' && $this->type == 'operator') {
          
          $operator = new AdminOperator();
          $operator->admin_id = \Yii::$app->user->id;
          $operator->operator_id = $this->id;

          $operator->save(false);
        }
      }
    }

    //convert password to md5
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
          
            //save operators for admin
            $this->saveOperators();
            
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
    
    private function saveOperators() {
      
      if(!$this->operators)
        return;
      
      AdminOperator::deleteAll('admin_id = '. $this->id);
      
      foreach ($this->operators as $operator_id) {
        
        $operator = new AdminOperator();
        $operator->admin_id = $this->id;
        $operator->operator_id = $operator_id;
        
        $operator->save(false);
      }
    }

    public static function getAllOperators() {
      
      return ArrayHelper::map(self::find()->where(['type' => 'operator'])->all(), 'id', function($user){

              return $user->first_name.' '.$user->last_name;
            });
    }
}