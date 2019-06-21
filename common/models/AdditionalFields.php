<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "additional_fields".
 *
 * @property int $id
 * @property string $name
 *
 * @property FieldsValue[] $fieldsValues
 * @property UseField[] $useFields
 */
class AdditionalFields extends \yii\db\ActiveRecord
{
    public $use = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'additional_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'use'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'use' => 'Применение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldsValues()
    {
        return $this->hasMany(FieldsValue::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUseFields()
    {
        return $this->hasMany(UseField::className(), ['field_id' => 'id']);
    }
}
