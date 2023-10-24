<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_tg_bot_token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $created_at
 * @property string $updated_at
 * @property string $expired_at
 *
 * @property User $user
 */
class UserTgBotToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tg_bot_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['token'], 'required'],
            [['created_at', 'updated_at', 'expired_at'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
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
            'token' => 'Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param string $tokenValue
     * @return bool
     */
    public static function checkExistsByToken(string $tokenValue): bool
    {
        return self::find()->where(['token' => $tokenValue])->exists();
    }
}
