<?php

namespace common\models;

use Mpdf\Tag\Th;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $user_id
 * @property int $parent_id
 * @property int $entity_type
 * @property int $entity_id
 * @property int $status
 * @property string $text
 */
class Comment extends \yii\db\ActiveRecord
{
    const ENTITY_TYPE_PROJECT = 1;
    const ENTITY_TYPE_TASK = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'parent_id', 'entity_type', 'entity_id', 'status'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'user_id' => 'Автор',
            'parent_id' => 'Родительский',
            'entity_type' => 'Сущность',
            'entity_id' => 'Идентификатор сущности',
            'status' => 'Статус',
            'text' => 'Текст',
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'created_at',
            'updated_at',
            'user_id',
            'user' => function () {
                return [
                    "fio" => $this->user->userCard->fio ?? $this->user->username,
                    "avatar" => $this->user->userCard->photo ?? '',
                ];
            },
            'parent_id',
            'entity_type',
            'entity_id',
            'status',
            'text',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return string[]
     */
    public static function getEntityTypeList(): array
    {
        return [
            self::ENTITY_TYPE_PROJECT => "Проект",
            self::ENTITY_TYPE_TASK => "Задача",
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => "Активен",
            self::STATUS_DISABLE => "Не активен",
        ];
    }
}
