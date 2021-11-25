<?php

namespace common\models;

use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $project_id
 * @property string $title
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $project_user_id
 * @property int $user_id
 * @property string $description
 *
 * @property Project $project
 * @property ProjectUser $projectUser
 * @property User $user
 * @property TaskUser[] $taskUsers
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'status', 'title', 'description', 'project_user_id'], 'required'],
            [['project_id', 'status', 'project_user_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['project_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectUser::className(), 'targetAttribute' => ['project_user_id' => 'id']],
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
            'title' => 'Название задачи',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'project_user_id' => 'Создатель',
            'user_id' => 'Наблюдатель',
            'description' => 'Описание',
        ];
    }

    public function beforeDelete()
    {
        foreach ($this->taskUsers as $taskUser){
            $taskUser->delete();
        }
        return parent::beforeDelete();
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
    public function getProjectUser()
    {
        return $this->hasOne(ProjectUser::className(), ['id' => 'project_user_id']);
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
    public function getTaskUsers()
    {
        return $this->hasMany(TaskUser::className(), ['task_id' => 'id']);
    }

    public static function usersByTaskArr($task_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith(['user', 'project'])->where(['project_id' => $task_id])->all(), 'id', 'user.username');
    }
}
