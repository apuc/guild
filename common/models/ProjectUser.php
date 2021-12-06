<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project_user".
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 *
 * @property Project $project
 * @property User $user
 * @property Task[] $tasks
 * @property TaskUser[] $taskUsers
 */
class ProjectUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'required'],
            ['user_id', 'unique', 'targetAttribute' => ['user_id', 'project_id'], 'message'=>'Сотрудник уже занят на этом проекте'],
            [['project_id', 'user_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Проект',
            'user_id' => 'Сотрудник',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(UserCard::className(), ['id_user' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasksByProject()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(TaskUser::className(), ['project_user_id' => 'id']);
    }

    public static function usersByProjectArr($project_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith('user')->where(['project_id' => $project_id])->all(), 'id', 'user.username');
    }

    public static function usersByTaskArr($task_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith(['tasksByProject', 'user'])->where(['task.id' => $task_id])->all(), 'id', 'user.username');
    }
}
