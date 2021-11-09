<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int $question_id
 * @property string $answer_body
 * @property int $answer_flag
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Question $question
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
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
            [['question_id', 'answer_flag', 'status'], 'integer'],
            [['answer_body', 'question_id', 'answer_flag', 'status'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['answer_body'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Вопрос',
            'answer_body' => 'Ответ',
            'answer_flag' => 'Флаг ответа',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    static function numCorrectAnswers($question_id)
    {
        return Answer::find()
            ->where('question_id=:question_id', [':question_id' => $question_id])
            ->andWhere('answer_flag=1')
            ->andWhere('status=1')
            ->count();
    }

    public static function activeAnswers($question_id): array
    {
        return self::find()->where(['question_id' => $question_id])
            ->andWhere(['status' => '1'])
            ->AsArray()
            ->all();
    }
}
