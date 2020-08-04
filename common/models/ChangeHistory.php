<?php

namespace common\Models;

class ChangeHistory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'change_history';
    }

    public function attributeLabels()
    {
        return [
            'table' => 'Таблица',
            'row_id' => 'ID строки',
            'field_name' => 'Имя поля',
            'old_value' => 'Старое значение',
            'new_value' => 'Новое значение',
            'label' => 'Поле',
        ];
    }

    public function translate()
    {

    }
}