<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project_mark".
 *
 * @property int $id
 * @property int $project_id
 * @property int $mark_id
 *
 * @property Mark $mark
 * @property Project $project
 */
class ProjectMark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'mark_id'], 'integer'],
            [['project_id', 'mark_id'], 'required'],
            [['project_id', 'mark_id'], 'unique', 'targetAttribute' => ['project_id', 'mark_id']],
            [['mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mark::className(), 'targetAttribute' => ['mark_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Проект',
            'mark_id' => 'Метка',
            'title' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasOne(Mark::className(), ['id' => 'mark_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public static function getMarkNotAtProject($project_id): array
    {
        $markIdList = ProjectMark::find()->where(['project_id' => $project_id])->select('mark_id')->column();

        $marks = Mark::find()
            ->where(['not in', 'id', $markIdList])
            ->all();
        return ArrayHelper::map($marks, 'id', 'title');
    }
}
