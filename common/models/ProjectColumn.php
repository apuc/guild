<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "project_column".
 *
 * @property int $id
 * @property string $title
 * @property int $project_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property int $priority
 *
 * @property Project $project
 */
class ProjectColumn extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_column';
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'title',
            'created_at',
            'updated_at',
            'project_id',
            'status',
            'priority',
            'tasks',
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'project_id'], 'required'],
            [['project_id', 'status', 'priority'], 'integer'],
            [['project_id', 'title'], 'unique', 'targetAttribute' => ['project_id', 'title']],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'project_id' => 'Проект',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'status' => 'Статус',
            'priority' => 'Приоритет',
        ];
    }

    /**
     * @return array[]
     */
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
     * @return string[]
     */
    public static function getStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DISABLE => 'Выключен'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(ProjectTask::class, ['column_id' => 'id'])
            ->with('taskUsers')
            ->where(['status' => ProjectTask::STATUS_ACTIVE])
            ->orderBy('priority');
    }
}
