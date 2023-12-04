<?php

namespace common\models;

/**
 * This is the model class for table "test_task".
 *
 * @property int $id
 * @property string $description
 * @property string $link
 * @property int $level
 * @property int $status
 */
class TestTask extends \yii\db\ActiveRecord
{
    const LEVEL_JUNIOR = 1;
    const LEVEL_MIDDLE = 2;
    const LEVEL_MIDDLE_PLUS = 3;
    const LEVEL_SENIOR = 4;

    /**
     * @return string[]
     */
    public static function getLevelList(): array
    {
        return [
            self::LEVEL_JUNIOR => 'Junior',
            self::LEVEL_MIDDLE => 'Middle',
            self::LEVEL_MIDDLE_PLUS => 'Middle+',
            self::LEVEL_SENIOR => 'Senior',
        ];
    }

    public static function getLevelLabel(int $level): string
    {
        return self::getLevelList()[$level];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'status', 'description', 'link'], 'required'],
            [['level', 'status'], 'integer'],
            [['description'], 'string', 'max' => 500],
            [['link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Описание',
            'link' => 'Ссылка',
            'level' => 'Уровень',
            'status' => 'Статус',
        ];
    }
}
