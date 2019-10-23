<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_card_accesses".
 *
 * @property int $id
 * @property int $accesses_id
 * @property int $user_card_id
 *
 * @property Accesses $accesses
 * @property UserCard $userCard
 */
class UserCardAccesses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_card_accesses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accesses_id', 'user_card_id'], 'integer'],
            [['accesses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Accesses::className(), 'targetAttribute' => ['accesses_id' => 'id']],
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
            'accesses_id' => 'Accesses ID',
            'user_card_id' => 'User Card ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasOne(Accesses::className(), ['id' => 'accesses_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'user_card_id']);
    }
}
