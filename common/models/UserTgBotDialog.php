<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "user_tg_bot_dialog".
 *
 * @property int $id
 * @property int $user_id
 * @property int $dialog_id
 * @property int $status
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $key_words
 *
 * @property User $user
 */
class UserTgBotDialog extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_ADMIN = 2;
    const STATUS_EXPERT = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tg_bot_dialog';
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
            [['user_id', 'dialog_id', 'status'], 'integer'],
            [['username', 'first_name', 'last_name', 'key_words'], 'string'],
            [['dialog_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['dialog_id'], 'unique'],
            [['user_id'], 'unique'],
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
            'user_id' => 'User ID',
            'dialog_id' => 'Dialog ID',
            'username' => 'TG username',
            'first_name' => 'TG first name',
            'last_name' => 'TG last name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'key_words' => 'Ключевые слова',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getStatus(): array
    {
        return [
            self::STATUS_NEW => "Новый",
            self::STATUS_ADMIN => "Админ",
        ];
    }
}
