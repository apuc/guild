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
            ['employee_id', 'unique', 'targetAttribute' => ['manager_id', 'employee_id'], 'message' => 'Этот сотрудник уже закреплён за менеджером'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employee_id' => 'id']],
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
            'user_id' => function(){
                return $this->employee_id;
            },
            'employee' => function () {
                return [
                    "fio" => $this->employee->userCard->fio ?? $this->employee->username,
                    "avatar" => $this->employee->userCard->photo ?? '',
                    "level_title" => \common\models\UserCard::getLevelList()[$this->employee->userCard->level] ?? '',
                    "position" => $this->employee->userCard->position ?? '',
                    "projects" => $this->employee->projectUserWithTitle,
                ];
            },
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEmployee(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'employee_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'employee_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManager(): ActiveQuery
    {
        return $this->hasOne(Manager::className(), ['id' => 'manager_id']);
    }
}
