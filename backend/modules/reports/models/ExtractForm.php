<?php

namespace backend\modules\reports\models;

class ExtractForm extends \yii\base\Model
{
    public $user_id;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['date_from', 'date_to', 'user_id'], 'required'],
            [['date_from', 'date_to'], 'safe'],
            [['user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'Пользователь',
            'date_from' => 'Дата начала',
            'date_to' => 'Дата окончания',
        ];
    }

}