<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property int $id
 * @property string $created_at
 * @property string $today
 * @property string $difficulties
 * @property string $tomorrow
 * @property int $user_card_id
 * @property int $status
 *
 * @property UserCard $userCard
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_card_id', 'status'], 'integer'],
            [['user_card_id', 'created_at', 'today'], 'required'],
            [['today', 'difficulties', 'tomorrow', 'created_at'], 'string', 'max' => 255],
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
            'created_at' => 'Дата заполнения отчета',
            'today' => 'Что было сделано сегодня?',
            'difficulties' => 'Какие сложности возникли?',
            'tomorrow' => 'Что планируется сделать завтра?',
            'user_card_id' => 'Пользователь',
            'status' => 'Статус'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'user_card_id']);
    }

    public static function getFio($data)
    {
        $user_card = UserCard::findOne(['id' => $data->user_card_id]);
        return $user_card->fio;
    }
}
