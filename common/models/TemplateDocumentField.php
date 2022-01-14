<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "template_document_field".
 *
 * @property int $id
 * @property int $template_id
 * @property int $field_id
 *
 * @property DocumentField $field
 * @property Template $template
 */
class TemplateDocumentField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template_document_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_id', 'field_id'], 'required'],
            [['template_id', 'field_id'], 'integer'],
            ['field_id', 'unique', 'targetAttribute' => ['template_id', 'field_id'], 'message'=>'Поле уже назначено'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentField::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Шаблон',
            'field_id' => 'Поле',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(DocumentField::className(), ['id' => 'field_id'])->asArray();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
