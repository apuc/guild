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
 * @property int $card_id_creator
 * @property int $card_id
 * @property string $description
 *
 * @property Project $project
 * @property UserCard $card
 * @property UserCard $cardIdCreator
 * @property TaskUser[] $taskUsers
 */
class Task extends ActiveRecord
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
            [['project_id', 'status', 'title', 'description', 'card_id_creator',], 'required'],
            [['project_id', 'status', 'card_id_creator', 'card_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['title', 'unique', 'targetAttribute' => ['title', 'project_id'], 'message'=>'Такая задача уже создана'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['card_id' => 'id']],
            [['card_id_creator'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['card_id_creator' => 'id']],
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
            'card_id_creator' => 'Создатель задачи',
            'card_id' => 'Наблюдатель',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'card_id']);
    }

    public function getUserCardCreator()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'card_id_creator']);
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
