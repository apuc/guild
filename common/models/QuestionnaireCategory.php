<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "questionnaire_category".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Questionnaire[] $questionnaires
 */
class QuestionnaireCategory extends \yii\db\ActiveRecord
{
    const STATUS_PASSIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaire_category';
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
            [['title', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название категории',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestionnaires()
    {
        return $this->hasMany(Questionnaire::className(), ['category_id' => 'id']);
    }
}
