<?php

namespace common\models;

use common\helpers\TransliteratorHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "document_field".
 *
 * @property int $id
 * @property string $title
 * @property string $field_template
 *
 * @property DocumentFieldValue[] $documentFieldValues
 * @property TemplateDocumentField[] $templateDocumentFields
 */
class DocumentField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'field_template'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        $this->field_template = TransliteratorHelper::transliterate($this->title);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'field_template' => 'Шаблон поля',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentFieldValues()
    {
        return $this->hasMany(DocumentFieldValue::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateDocumentFields()
    {
        return $this->hasMany(TemplateDocumentField::className(), ['field_id' => 'id']);
    }

    public static function getIdFieldsTitleList($template_id): array
    {
        return
            self::find()->joinWith('templateDocumentFields')
                ->where(['template_document_field.template_id' => $template_id])
                ->asArray()->all();
    }
}
