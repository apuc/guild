<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tg_bot_msg".
 *
 * @property int $id
 * @property int $dialog_id
 * @property int $ig_dialog_id
 * @property string $text
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class TgBotMsg extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_READY_TO_SEND = 2;
    const STATUS_SENT = 3;

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
        return 'tg_bot_msg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dialog_id'], 'required'],
            [['dialog_id', 'ig_dialog_id', 'status'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dialog_id' => 'Dialog ID',
            'ig_dialog_id' => 'Ig Dialog ID',
            'text' => 'Text',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getDialog(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TgBotMsg::class, ['id' => 'dialog_id']);
    }

    public static function getStatus(): array
    {
        return [
            self::STATUS_NEW => "Новое",
            self::STATUS_READY_TO_SEND => "Готово к отправке",
            self::STATUS_SENT => "Отправлено",
        ];
    }
}
