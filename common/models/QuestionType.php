<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question_type".
 *
 * @property int $id
 * @property string $question_type
 * @property string $slug
 *
 * @property Question[] $questions
 */
class QuestionType extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question_type';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'question_type',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_type' => 'Тип вопроса',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['question_type_id' => 'id']);
    }
}
