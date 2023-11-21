<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_role".
 *
 * @property int $id
 * @property string $title
 *
 * @property ProjectUser[] $projectUsers
 */
class ProjectRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_role';
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
            'title' => 'Название роли',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['project_role_id' => 'id']);
    }
}
