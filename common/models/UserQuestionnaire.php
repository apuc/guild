<?php

namespace common\models;

use common\helpers\UUIDHelper;
use Exception;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use backend\modules\questionnaire\models\Question;
use backend\modules\questionnaire\models\UserResponse;
use \backend\modules\questionnaire\models\Answer;

/**
 * This is the model class for table "user_questionnaire".
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $user_id
 * @property string $uuid
 * @property string $created_at
 * @property string $updated_at
 * @property int $score
 * @property int $status
 * @property double $percent_correct_answers
 *
 * @property Questionnaire $questionnaire
 * @property User $user
 * @property UserResponse[] $userResponses
 */
class UserQuestionnaire extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_questionnaire';
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
            [['questionnaire_id', 'user_id', 'status'], 'required'],
            [['questionnaire_id', 'user_id', 'score', 'status'], 'integer'],
            [['percent_correct_answers'], 'number'],
            [['created_at', 'updated_at', 'testing_date'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['uuid'], 'unique'],
            [['questionnaire_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questionnaire::className(), 'targetAttribute' => ['questionnaire_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (empty($this->uuid)) {
                $this->uuid = UUIDHelper::v4();
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
            'questionnaire_id' => 'Анкета',
            'user_id' => 'Пользователь',
            'uuid' => 'UUID',
            'score' => 'Балы',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'testing_date' => 'Дата тестирования',
            'percent_correct_answers' => 'Процент правильных ответов',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestionnaire(): ActiveQuery
    {
        return $this->hasOne(Questionnaire::className(), ['id' => 'questionnaire_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserResponses(): ActiveQuery
    {
        return $this->hasMany(UserResponse::className(), ['user_questionnaire_uuid' => 'uuid']);
    }

    public function getQuestionnaireTitle()
    {
        return $this->getQuestionnaire()->one()->title;
    }

    public function getUserName()
    {
        return $this->getUser()->one()->username;
    }

    /**
     * @throws InvalidConfigException
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
            ->viaTable('user_response', ['user_questionnaire_uuid' => 'uuid']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function numCorrectAnswersWithoutOpenQuestions()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'question_id'])
            ->viaTable('user_response', ['user_questionnaire_uuid' => 'uuid'])
            ->where(['answer_flag' => '1'])
            ->andWhere(['status' => '1'])
            ->count();
    }

    /**
     * @throws InvalidConfigException
     */
    public function numOpenQuestionsAnswers()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
            ->viaTable('user_response', ['user_questionnaire_uuid' => 'uuid'])
            ->where(['question_type_id' => '1'])
            ->count();
    }

    /**
     * @throws Exception
     */
    public static function getQuestionnaireId($uuid)
    {
        return ArrayHelper::getValue(self::find()->where(['uuid' => $uuid])->one(), 'questionnaire_id');
    }

    public static function findActiveUserQuestionnaires($user_id): array
    {
        $models =  self::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['user_questionnaire.status' => '1'])
            ->all();

        $modelsArr = array();
        foreach ($models as $model) {
            $modelsArr[] = array_merge($model->toArray(), [
                'questionnaire_title' => $model->getQuestionnaireTitle()
            ]);
        }

        return $modelsArr;
    }
}
