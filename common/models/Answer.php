<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
    const STATUS_PASSIVE = 0;
    const STATUS_ACTIVE = 1;

    const FLAG_TRUE = 1;
    const FLAG_FALSE = 0;

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
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }


    public function getQuestionBody()
    {
        return $this->getQuestion()->one()->question_body;
    }

    public function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_PASSIVE => 'Не используется'
        ];
    }

    public function getStatusText()
    {
        return $this->statuses[$this->status];
    }

    public function getFlags()
    {
        return [
            self::FLAG_TRUE => 'Правильный',
            self::FLAG_FALSE => 'Ошибочный',
        ];
    }

    public function getFlagText()
    {
        return $this->flags[$this->status];
    }

    static function getCorrectAnswersNum($question_id)
    {
        return Answer::find()
            ->where('question_id=:question_id', [':question_id' => $question_id])
            ->andWhere('answer_flag=1')
            ->andWhere('status=1')
            ->count();
    }

    public static function getActiveAnswers($question_id)
    {
        return self::find()->where(['question_id' => $question_id])
            ->andWhere(['status' => '1'])
            ->AsArray()
            ->all();
    }
}
