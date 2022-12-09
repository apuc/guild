<?php

namespace common\models;

/**
 * This is the model class for table "document_field_value".
 *
 * @property int $id
 * @property int $document_field_id
 * @property int $document_id
 * @property string $value
 *
 * @property Document $document
 * @property DocumentField $documentField
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
            [['document_field_id', 'document_id', 'value'], 'required'],
            [['document_field_id', 'document_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            ['value', 'unique', 'targetAttribute' => ['document_id', 'value'], 'message'=>'Значение каждого поля должно быть уникально в пределах документа'], //
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['document_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentField::className(), 'targetAttribute' => ['document_field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_field_id' => 'Поле',
            'document_id' => 'Документ',
            'value' => 'Значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentField()
    {
        return $this->hasOne(DocumentField::className(), ['id' => 'document_field_id']);
    }
}
