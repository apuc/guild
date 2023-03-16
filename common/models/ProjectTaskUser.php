<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "task_user".
 *
 * @property int $id
 * @property int $task_id
 * @property int $project_user_id
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
            [['task_id', 'project_user_id'], 'required'],
            ['project_user_id', 'unique', 'targetAttribute' => ['task_id', 'project_user_id'], 'message'=>'Уже закреплён(ы) за задачей'],
            [['project_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectUser::className(), 'targetAttribute' => ['project_user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectTask::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'project_user_id' => 'Сотрудник',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectUser()
    {
        return $this->hasOne(ProjectUser::className(), ['id' => 'project_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(ProjectTask::className(), ['id' => 'task_id']);
    }
}
