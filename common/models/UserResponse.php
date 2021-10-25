<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use \backend\modules\questionnaire\models\UserQuestionnaire;

/**
 * This is the model class for table "user_response".
 *
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property string $response_body
 * @property string $created_at
 * @property string $updated_at
 * @property int $user_questionnaire_id
 * @property double $answer_flag
 *
 * @property UserQuestionnaire $userQuestionnaire
 * @property Question $question
 * @property User $user
 */
class UserResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_response';
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
            [['user_id', 'question_id', 'user_questionnaire_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['answer_flag'], 'number'],
            [['response_body'], 'string', 'max' => 255],
            [['user_questionnaire_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserQuestionnaire::className(), 'targetAttribute' => ['user_questionnaire_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
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
            'user_id' => 'Пользователь',
            'question_id' => 'Вопрос',
            'response_body' => 'Ответ пользователя',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'answer_flag' => 'Корректность',
            'user_questionnaire_id' => 'Анкеты',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUserQuestionnaire()
    {
        return $this->hasOne(UserQuestionnaire::className(), ['id' => 'user_questionnaire_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserName()
    {
        return $this->getUser()->one()->username;
    }

    public function getQuestionBody()
    {
        return $this->getQuestion()->one()->question_body;
    }

    private function getCorrectAnswers()
    {
        return $this->hasMany(Answer::class, ['question_id' => 'question_id'])
            ->where(['answer_flag' => '1'])->all();
    }

    public function getQuestionnaireTitle()
    {
        $tmp = $this->hasOne(Questionnaire::className(), ['id' => 'questionnaire_id'])
            ->viaTable('user_questionnaire', ['id' => 'user_questionnaire_id'])->one();

        $value = ArrayHelper::getValue($tmp, 'title');

        return $value;
    }


    public function getQuestionType()
    {
        $qType = $this->hasOne(QuestionType::class, ['id' => 'question_type_id'])
            ->viaTable('question', ['id' => 'question_id'])->one();

        $value = ArrayHelper::getValue($qType, 'question_type');

        return $value;
    }

    public function getQuestionTypeValue()
    {
        $qType = $this->getQuestion()->one();

        $value = ArrayHelper::getValue($qType, 'question_type_id');

        return $value;
    }

    public function rateResponse()
    {
        if ($this->answer_flag === null && $this->getQuestionTypeValue() != 1)  // not open question
        {
            $correct_answers = $this->getCorrectAnswers();

            foreach ($correct_answers as $correct_answer)
            {
                if ($this->response_body === $correct_answer['answer_body'])
                {
                    $this->answer_flag = 1;
                    $this->save();
                    return;
                }
            }
            $this->answer_flag = 0;
            $this->save();
        }
    }
}
