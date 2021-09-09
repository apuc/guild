<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_card_accesses".
 *
 * @property int $id
 * @property int $user_card_id
 * @property int $achievement_id
 *
 * @property Accesses $accesses
 * @property UserCard $userCard
 */
class AchievementUserCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievement_user_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_card_id', 'achievement_id'], 'integer'],
            [['achievement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Achievement::className(), 'targetAttribute' => ['achievement_id' => 'id']],
            [['user_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['user_card_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'achievement_id' => 'Achievement ID',
            'user_card_id' => 'User Card ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchievement()
    {
        return $this->hasOne(Achievement::className(), ['id' => 'achievement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'user_card_id']);
    }
}
