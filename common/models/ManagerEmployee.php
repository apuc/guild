<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "manager_employee".
 *
 * @property int $id
 * @property int $manager_id
 * @property int $employee_id
 *
 * @property Manager $manager
 * @property UserCard $userCard
 */
class ManagerEmployee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manager_employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manager_id', 'employee_id'], 'required'],
            [['manager_id'], 'integer'],
            ['employee_id', 'unique', 'targetAttribute' => ['manager_id', 'user_card_id'], 'message' => 'Этот сотрудник уже закреплён за менеджером'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['user_card_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'employee_id' => 'Карточка работника',
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'manager_id',
            'employee_id',
            'employee' => function () {
                return [
                    "fio" => $this->employee->userCard->fio ?? $this->employee->username,
                    "avatar" => $this->employee->userCard->photo ?? '',
                ];
            },
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::class, ['id' => 'employee_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['id' => 'manager_id']);
    }
}
