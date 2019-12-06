<?php

namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Html;

/**
 * This is the model class for table "fields_value_new".
 *
 * @property int $id
 * @property int $field_id
 * @property int $item_id
 * @property int $item_type
 * @property int $order
 * @property string $value
 * @property string $option
 * @property string $type_file
 */
class FieldsValueNew extends \yii\db\ActiveRecord
{
    const TYPE_PROFILE = 0;
    const TYPE_PROJECT = 1;
    const TYPE_COMPANY = 2;
    const TYPE_BALANCE = 3;
    const TYPE_NOTE = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields_value_new';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'item_id', 'item_type'], 'required'],
            [['field_id', 'item_id', 'item_type', 'order'], 'integer'],
            [['value', 'type_file'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Field ID',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'order' => 'Order',
            'value' => 'Value',
            'type_file' => 'Тип файла'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AdditionalFields::class, ['id' => 'field_id']);
    }
    
    /**
     * get value for view
     * @return string
     */
    public function getValue()
    {
        $test = $this->type_file === 'file' ? $this->getFileValue() : $this->getTextValue();
        return $test;
    }

    /**
     * @return string
     */
    private function getFileValue()
    {
        $filename = $this->getFileName();
        $filePath = Yii::getAlias('@frontend/web' . $this->value);
        if ($this->isImage()) {
            $imageHTML = Html::img($this->value, ['width' => '200px', 'alt' => $filename]);
            $downloadLinkHTML = ' (' . Html::a('Скачать', $this->value, ['target' => '_blank', 'download' => $filename]) . ')';
            $result = $imageHTML . $downloadLinkHTML;
        } else {
            $imageHTML = Html::img('/media/file.png', ['width' => '100px', 'alt' => $filename]);
            $downloadLinkHTML = ' (' . Html::a('Скачать', $this->value, ['target' => '_blank', 'download' => $filename]) . ')';;
            $result = $imageHTML . $filename . $downloadLinkHTML;
        }
        return $result;
    }

    /**
     * @return string
     */
    private function getTextValue()
    {
        return $this->value;
    }

    /**
     * @return mixed|string
     */
    public function getFileName()
    {
        if ($this->type_file === 'file') {
            $explode = explode('/', $this->value);
            $filename = array_pop($explode);
            return $filename;
        }
        return $this->value;
    }

    /**
     * File is image?
     * @return bool
     */
    public function isImage()
    {
        if ($this->type_file === 'text') {
            return false;
        }

        try {
            $mime = mime_content_type(Yii::getAlias('@frontend/web' . $this->value));
        } catch (ErrorException $e) {
            return false;
        }

        $extension = explode('/', $mime)['0'];
        if ($extension === 'image') {
            return true;
        } else {
            return false;
        }
    }

}
