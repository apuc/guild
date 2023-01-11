<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property int $question_type_id
 * @property int $questionnaire_id
 * @property string $question_body
 * @property int $question_priority
 * @property int $next_question
 * @property int $status
 * @property int $score
 * @property string $time_limit
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Answer[] $answers
 * @property Questionnaire $questionnaire
 * @property QuestionType $questionType
 * @property UserResponse[] $userResponses
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
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
            [['status', 'question_type_id', 'questionnaire_id', 'question_body', 'score'], 'required'],
            [['question_type_id', 'questionnaire_id', 'question_priority', 'next_question', 'status', 'score'], 'integer'],
            [['created_at', 'updated_at', 'time_limit'], 'safe'],
            [['question_body'], 'string', 'max' => 255],
            [['questionnaire_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questionnaire::className(), 'targetAttribute' => ['questionnaire_id' => 'id']],
            [['question_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionType::className(), 'targetAttribute' => ['question_type_id' => 'id']],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (strtotime($this->time_limit, '0') === 0)
            {
                $this->time_limit = null;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_type_id' => 'Тип вопроса',
            'questionnaire_id' => 'Анкета',
            'question_body' => 'Вопрос',
            'question_priority' => 'Приоритет вопроса',
            'next_question' => 'Следующий вопрос',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'time_limit' => 'Время на ответ',
            'score' => 'Балы за вопрос',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaire()
    {
        return $this->hasOne(Questionnaire::className(), ['id' => 'questionnaire_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionType()
    {
        return $this->hasOne(QuestionType::className(), ['id' => 'question_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResponses()
    {
        return $this->hasMany(UserResponse::className(), ['question_id' => 'id']);
    }

    public static function activeQuestions($questionnaire_id): array
    {
        return self::find()->where(['questionnaire_id' => $questionnaire_id])
            ->andWhere(['status' => '1'])
            ->all();
    }
}
