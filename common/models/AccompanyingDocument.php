<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accompanying_document".
 *
 * @property int $id
 * @property int $document_id
 * @property string $title
 *
 * @property Document $document
 */
class AccompanyingDocument extends \yii\db\ActiveRecord
{
    public $accompanying_document;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accompanying_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id'], 'integer'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['template_file_name', 'title'], 'required'],
            [['accompanying_document'], 'required', 'message'=>'Укажите путь к файлу'],
            [['accompanying_document'], 'file', 'maxSize' => '100000'],
            [['accompanying_document'], 'file', 'skipOnEmpty' => true, 'extensions' => 'docx'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_id' => 'Документ',
            'title' => 'Название',
            'accompanying_document' => 'Сопроводительный документ'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }
}
