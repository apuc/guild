<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Document[] $documents
 * @property TemplateDocumentField[] $templateDocumentFields
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
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
            [['created_at', 'updated_at'], 'safe'],
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
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    public function beforeDelete()
    {
        foreach ($this->templateDocumentFields as $templateDocumentField){
            $templateDocumentField->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateDocumentFields()
    {
        return $this->hasMany(TemplateDocumentField::className(), ['template_id' => 'id']);
    }
}
