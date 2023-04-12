<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "knowledge_level".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 */
class KnowledgeLevel extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'knowledge_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'status' => 'Статус',
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DISABLE => 'Выключен'
        ];
    }


}
