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
            self::USE_PROJECT => 'Проект'
        ];
    }

    /**
     * @return string status text label
     */
    public function getStatusesText()
    {
        return $this->statuses[$this->status_id];
    }
}
