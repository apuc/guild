<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "use_status".
 *
 * @property int $id
 * @property int $status_id
 * @property int $use
 *
 * @property array $statuses
 * @property string $statusesText
 *
 * @property Status $status
 */
class UseStatus extends \yii\db\ActiveRecord
{
    const USE_PROFILE = 0;
    const USE_PROJECT = 1;
    const USE_COMPANY = 2;
    const USE_BALANCE = 3;
    const USE_NOTE= 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'use_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id', 'use'], 'required'],
            [['status_id', 'use'], 'integer'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'Статус',
            'use' => 'Применение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    public function getStatuses()
    {
        return [
            self::USE_PROFILE => 'Профиль',
            self::USE_PROJECT => 'Проект',
            self::USE_COMPANY => 'Компания',
            self::USE_BALANCE => 'Баланс',
            self::USE_NOTE => 'Заметка'
        ];
    }

    /**
     * @return string status text label
     */
    public static function getStatusesText($id)
    {
        $model = new self();
        return $model->statuses[$id];
    }
}
