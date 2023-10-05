<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mark".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $color
 * @property int $status
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
            [['title', 'slug', 'color'], 'string', 'max' => 255],
            [['status'], 'integer'],
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
            'slug' => 'Ключ',
            'color' => 'Цвет',
            'status' => 'Статус',
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
