<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tgparsing".
 *
 * @property int $id
 * @property int $channel_id
 * @property int $post_id
 * @property string $channel_title
 * @property string $content
 * @property string $channel_link
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class Tgparsing extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_READY_TO_SEND = 2;
    const STATUS_SENT = 3;
    const STATUS_SENT_TO_ADMIN = 4;
    const STATUS_REQUEST_SENT = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tgparsing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['channel_id'], 'required'],
            [['channel_id', 'status', 'post_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['channel_title', 'channel_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
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
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Канал ID',
            'channel_title' => 'Название канала',
            'channel_link' => 'Ссылка на канал',
            'post_id' => 'Пост ID',
            'content' => 'Пост',
            'created_at' => 'Создан',
            'updated_at' => 'Отредактирован',
            'status' => 'Статус',
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatus(): array
    {
        return [
            self::STATUS_NEW => "Новый",
            self::STATUS_READY_TO_SEND => "Готов к отправке",
            self::STATUS_SENT => "Отправлен",
            self::STATUS_SENT_TO_ADMIN => "Отправлено администратору",
            self::STATUS_REQUEST_SENT => "Запрос отправлен",
        ];
    }
}
