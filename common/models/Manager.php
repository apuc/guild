<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "manager".
 *
 * @property int $id
 * @property int $user_card_id
 *
 * @property UserCard $userCard
 * @property ManagerEmployee[] $managerEmployees
 */
class Manager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_card_id'], 'integer'],
            [['user_card_id'], 'required'],
            ['user_card_id', 'unique', 'message'=>'Уже является менеджером'],
            [['user_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['user_card_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_card_id' => 'Карточка менеджера',
        ];
    }

    public function beforeDelete()
    {
        foreach ($this->managerEmployees as $employee){
            $employee->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'user_card_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManagerEmployees()
    {
        return $this->hasMany(ManagerEmployee::className(), ['manager_id' => 'id']);
    }
}
