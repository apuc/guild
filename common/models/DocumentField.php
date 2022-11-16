<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "document_field".
 *
 * @property int $id
 * @property string $title
 * @property string $field_template
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

    public static function getTitleFieldTemplateArr(): array
    {
        return ArrayHelper::map(self::find()->all(), 'title', 'field_template');
    }
}
