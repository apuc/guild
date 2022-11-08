<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document_template".
 *
 * @property int $id
 * @property string $title
 * @property string $template_body
 */
class DocumentTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_body'], 'string'],
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
            'title' => 'Title',
            'template_body' => 'Template Body',
        ];
    }
}
