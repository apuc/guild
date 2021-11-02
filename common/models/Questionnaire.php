<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "questionnaire".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $time_limit
 *
 * @property Question[] $questions
 * @property QuestionnaireCategory $category
 * @property UserQuestionnaire[] $userQuestionnaires
 */
class Questionnaire extends \yii\db\ActiveRecord
{
    const STATUS_PASSIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaire';
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
            [['category_id', 'status', 'title'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'time_limit'], 'safe'],
            ['title', 'unique'],
            [['title'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionnaireCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Название анкеты',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'time_limit' => 'Время на выполнение (HH:mm)',
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
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['questionnaire_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id'])
            ->viaTable('question', ['questionnaire_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(QuestionnaireCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestionnaires()
    {
        return $this->hasMany(UserQuestionnaire::className(), ['questionnaire_id' => 'id']);
    }

    public function getCategoryTitle()
    {
        return $this->getCategory()->one()->title;
    }

    public static function getQuestionnaireByCategory($category_id)
    {
        $categories = self::find()->where(['category_id' => $category_id,   'status' => '1'])->all();
        $catArr = ArrayHelper::map($categories, 'id', 'title');

        $formattedCatArr = array();
        foreach ($catArr as $key => $value){
            $formattedCatArr[] = array('id' => $key, 'name' => $value);
        }

        return $formattedCatArr;
    }
}
