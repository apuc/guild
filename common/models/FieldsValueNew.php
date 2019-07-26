<?php

namespace common\models;

use Yii;

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

}
