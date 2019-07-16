<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 *@property int $id
 *@property int $card_id
 * @property int $dt_start
 * @property int $dt_end
 */
class Holiday extends ActiveRecord
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public static function tableName()
    {
        return 'holiday'; // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['card_id', 'dt_start', 'dt_end'], 'integer'],
            [['card_id', 'dt_start', 'dt_end'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'card_id' => 'ID пользователя',
            'dt_start' => 'Дата начала отпуска',
            'dt_end' => 'Дата конца отпуска'
        ];
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->dt_start = date('d-m-Y', $this->dt_start);
        $this->dt_end = date('d-m-Y', $this->dt_end);
    }

    public function getUsers()
    {
        return $this->hasOne(UserCard::className(),['id' => 'card_id']);
    }
}