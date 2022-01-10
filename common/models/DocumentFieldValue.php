<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "document_field_value".
 *
 * @property int $id
 * @property int $field_id
 * @property int $document_id
 * @property string $value
 *
 * @property Document $document
 * @property DocumentField $field
 */
class DocumentFieldValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_field_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'document_id', 'value'], 'required'],
            [['field_id', 'document_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            ['field_id', 'unique', 'targetAttribute' => ['field_id', 'document_id'], 'message'=>'Поле уже используется'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentField::className(), 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Поле',
            'document_id' => 'Документ',
            'value' => 'Значение',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getField(): ActiveQuery
    {
        return $this->hasOne(DocumentField::className(), ['id' => 'field_id']);
    }
}
