<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "position".
 *
 * @property int $id
 * @property string $name
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    public function getUserCard(): \yii\db\ActiveQuery
    {
        return $this->hasMany(UserCard::class, ['position_id' => 'id']);
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
