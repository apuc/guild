<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_accesses".
 *
 * @property int $id
 * @property int $accesses_id
 * @property int $project_id
 *
 * @property Accesses $accesses
 * @property Project $project
 */
class ProjectAccesses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_accesses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accesses_id', 'project_id'], 'integer'],
            [['accesses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Accesses::className(), 'targetAttribute' => ['accesses_id' => 'id']],
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
            'accesses_id' => 'Accesses ID',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasOne(Accesses::className(), ['id' => 'accesses_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
