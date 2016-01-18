<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_operator".
 *
 * @property integer $id
 * @property integer $admin_id
 * @property integer $operator_id
 */
class AdminOperator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_operator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'operator_id'], 'required'],
            [['admin_id', 'operator_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'operator_id' => 'Operator ID',
        ];
    }
}
