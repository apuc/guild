<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mark".
 *
 * @property int $id
 * @property string $title
 *
 * @property ProjectMark[] $projectMarks
 */
class Mark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectMarks()
    {
        return $this->hasMany(ProjectMark::className(), ['mark_id' => 'id']);
    }
}
