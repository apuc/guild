<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill".
 *
 * @property int $id
 * @property string $name
 * @property integer $category_id
 *
 * @property CardSkill[] $cardSkills
 */
class Skill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardSkills()
    {
        return $this->hasMany(CardSkill::className(), ['skill_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(SkillCategory::class, ['id' => 'category_id']);
    }

    public static function getNameById($id)
    {
        $model = self::find()->where(['id' => $id])->one();
        return $model ? $model->name : null;
    }
}
