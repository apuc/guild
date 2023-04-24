<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "task_user".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 *
 * @property ProjectUser $projectUser
 * @property ProjectTask $task
 */
class ProjectTaskUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_task_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'required'],
            ['user_id', 'unique', 'targetAttribute' => ['task_id', 'user_id'], 'message' => 'Уже закреплён(ы) за задачей'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectTask::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'task_id',
            'user_id',
            'fio' => function () {
                return $this->user->userCard->fio ?? $this->user->username;
            },
            'avatar' => function () {
                return $this->user->userCard->photo ?? '';
            }
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Задача',
            'user_id' => 'Сотрудник',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(ProjectTask::className(), ['id' => 'task_id']);
    }
}
