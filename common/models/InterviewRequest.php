<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "interview_request".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property int $profile_id
 * @property int $user_id
 * @property int $created_at
 * @property string $comment
 */
class InterviewRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interview_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['profile_id', 'user_id', 'created_at'], 'integer'],
            [['email', 'phone'], 'string', 'max' => 255],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'profile_id' => 'Profile ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'comment' => 'Комментарий',
        ];
    }
}
