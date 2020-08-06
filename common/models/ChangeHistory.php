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

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        //milliseconds to date
        if ($this->field_name == 'dt_start' || $this->field_name == 'dt_end' || $this->field_name == 'dt_add') {
            $this->old_value = date('d-m-Y', $this->old_value);
            $this->new_value = date('d-m-Y', $this->new_value);
        }
    }
}