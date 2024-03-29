<?php

namespace common\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
 * @property double $answer_flag
 * @property string $user_questionnaire_uuid
 *
 * @property UserQuestionnaire $userQuestionnaire
 * @property Question $question
 * @property User $user
 */
class UserResponse extends ActiveRecord
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
            [['user_id', 'question_id', 'answer_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['answer_flag'], 'number'],
            [['response_body'], 'string', 'max' => 255],
            [['user_questionnaire_uuid'], 'string', 'max' => 36],
            [['user_questionnaire_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => UserQuestionnaire::className(), 'targetAttribute' => ['user_questionnaire_uuid' => 'uuid']],
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
            'answer_id' => 'Идентификатор ответа',
            'response_body' => 'Ответ пользователя',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'answer_flag' => 'Корректность',
            'user_questionnaire_uuid' => 'UUID анкеты',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUserQuestionnaire()
    {
        return $this->hasOne(UserQuestionnaire::className(), ['uuid' => 'user_questionnaire_uuid']);
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
    public function getAnswer(): ActiveQuery
    {
        return $this->hasOne(Answer::class, ['id' => 'answer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getQuestionnaire()
    {
        return $this->hasOne(Questionnaire::className(), ['id' => 'questionnaire_id'])
            ->viaTable('user_questionnaire', ['uuid' => 'user_questionnaire_uuid']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getQuestionType()
    {
        return $this->hasOne(QuestionType::class, ['id' => 'question_type_id'])
            ->viaTable('question', ['id' => 'question_id']);
    }

    public function getCorrectAnswers()
    {
        return $this->hasMany(Answer::class, ['question_id' => 'question_id'])
            ->where(['answer_flag' => '1'])->all();
    }

    public function getQuestionTypeValue()
    {
        $qType = $this->getQuestion()->one();
        return ArrayHelper::getValue($qType, 'question_type_id');
    }
}
