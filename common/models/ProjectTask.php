<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
 * @property int $column_id
 * @property int $user_id
 * @property int $executor_id
 * @property int $priority
 * @property string $description
 * @property string $dead_line
 *
 * @property Project $project
 * @property User $user
 * @property UserCard $card
 * @property UserCard $cardIdCreator
 * @property Mark[] $mark
 * @property MarkEntity[] $markEntity
 * @property ProjectTaskUser[] $taskUsers
 */
class ProjectTask extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

//    const PRIORITY_LOW = 0;
//    const PRIORITY_MEDIUM = 1;
//    const PRIORITY_HIGH = 2;
//
//    /**
//     * @return string[]
//     */
//    public static function priorityList() :array
//    {
//        return [
//            self::PRIORITY_LOW => 'Низкий',
//            self::PRIORITY_MEDIUM => 'Средний',
//            self::PRIORITY_HIGH => 'Высокий',
//        ];
//    }

//    /**
//     * @param $priority
//     * @return string
//     * @throws \Exception
//     */
//    public static function getPriority($priority): string
//    {
//        return ArrayHelper::getValue(self::priorityList(), $priority);
//    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_task';
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
            [['project_id', 'status', 'title', 'description',], 'required'],
            [['project_id', 'status', 'column_id', 'user_id', 'executor_id', 'priority'], 'integer'],
            [['created_at', 'updated_at', 'dead_line'], 'safe'],
//            ['status', 'in', 'range' => [self::PRIORITY_LOW, self::PRIORITY_MEDIUM, self::PRIORITY_HIGH]],
            ['title', 'unique', 'targetAttribute' => ['title', 'project_id'], 'message' => 'Такая задача уже создана'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1500],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['column_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectColumn::className(), 'targetAttribute' => ['column_id' => 'id']],
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
            'description' => 'Описание',
            'user_id' => 'Создатель задачи',
            'column_id' => 'Колонка',
            'executor_id' => 'Исполнитель',
            'priority' => 'Приоритет',
            'dead_line' => 'Срок выполнения задачи',
        ];
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'project_id',
            'project_name' => function () {
                return $this->project->name ?? null;
            },
            'title',
            'created_at',
            'updated_at',
            'dead_line',
            'description',
            'status',
            'column_id',
            'user_id',
            'user' => function () {
                return [
                    "fio" => $this->user->userCard->fio ?? $this->user->id,
                    "avatar" => $this->user->userCard->photo ?? '',
                ];
            },
            'executor_id',
            'priority',
            'executor' => function () {
                if ($this->executor) {
                    return [
                        "fio" => $this->executor->userCard->fio ?? $this->executor->username,
                        "avatar" => $this->executor->userCard->photo ?? '',
                    ];
                }

                return null;
            },
            'comment_count' => function () {
                return Comment::find()->where(['entity_id' => $this->id, 'entity_type' => 2, 'status' => Comment::STATUS_ACTIVE])->count();
            },
            'taskUsers',
            'mark'
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [
            'timers',
            'column' => function () {
                return [
                    'column_title' => $this->column->title ?? null
                ];
            },
            'mark'
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

    public function beforeDelete()
    {
        foreach ($this->taskUsers as $taskUser) {
            $taskUser->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getColumn(): ActiveQuery
    {
        return $this->hasOne(ProjectColumn::class, ['id' => 'column_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(ProjectTaskUser::className(), ['task_id' => 'id']);
    }

    public function getTimers()
    {
        return $this->hasMany(Timer::class, ['entity_id' => 'id'])->where(['status' => Timer::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasMany(Mark::class, ['id' => 'mark_id'])
            ->via('markEntity');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkEntity()
    {
        return $this->hasMany(MarkEntity::class, ['entity_id' => 'id'])
            ->where(['entity_type' => Entity::ENTITY_TYPE_TASK]);
    }

    public static function usersByTaskArr($task_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith(['user', 'project'])->where(['project_id' => $task_id])->all(), 'id', 'user.username');
    }
}
