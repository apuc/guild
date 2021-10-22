<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property Skill[] $skills
 */
class SkillCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
    public function getSkills()
    {
        return $this->hasMany(Skill::className(), ['category' => 'id']);
    }

    public static function getAll()
    {
        return self::find()->all();
    }
}
