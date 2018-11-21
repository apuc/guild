<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hh".
 *
 * @property int $id
 * @property int $hh_id
 * @property string $url
 * @property string $title
 * @property int $dt_add
 * @property string $photo
 */
class Hh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hh_id', 'dt_add'], 'integer'],
            [['url'], 'required'],
            [['url', 'title', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hh_id' => 'Hh ID',
            'url' => 'Url',
            'title' => 'Название',
            'dt_add' => 'Дата добавления',
            'photo' => 'Фото',
        ];
    }
}
