<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "achievement".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $img
 * @property string $description
 * @property integer $status
 */
class Achievement extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 2;

    public static function getStatusLabel():array
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_DISABLE => 'Не активна'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            [['status'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['description', 'img'], 'string'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'slug' => 'Slug',
            'description' => 'Описание',
            'status' => 'Статус',
            'img' => 'Изображение',
        ];
    }
}
