<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "manager".
 *
 * @property int $id
 * @property int $user_id
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
            [['user_id'], 'integer'],
            [['user_id'], 'required'],
            ['user_id', 'unique', 'message' => 'Уже является менеджером'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Карточка менеджера',
        ];
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function beforeDelete()
    {
        foreach ($this->managerEmployees as $employee) {
            $employee->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManagerEmployees()
    {
        return $this->hasMany(ManagerEmployee::className(), ['manager_id' => 'id']);
    }
}
