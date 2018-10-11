<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $name
 *
 * @property UseStatus[] $useStatuses
 * @property UserCard[] $userCards
 */
class Status extends \yii\db\ActiveRecord
{
    public $use = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
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
    public function getUseStatuses()
    {
        return $this->hasMany(UseStatus::class, ['status_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCards()
    {
        return $this->hasMany(UserCard::class, ['status' => 'id']);
    }
}
