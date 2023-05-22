<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "timer".
 *
 * @property int $id
 * @property string $created_at
 * @property string $stopped_at
 * @property int $user_id
 * @property int $entity_type
 * @property int $entity_id
 * @property int $status
 */
class Timer extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'stopped_at'], 'safe'],
            [['user_id', 'entity_type', 'entity_id'], 'required'],
            [['user_id', 'entity_type', 'entity_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'stopped_at' => 'Stopped At',
            'user_id' => 'User ID',
            'entity_type' => 'Entity Type',
            'entity_id' => 'Entity ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id',
            'user_id',
            'created_at',
            'stopped_at',
            'entity_id',
            'entity_type',
            'delta' => function(){
                return $this->getDelta();
            },
            'deltaSeconds' => function(){
                return $this->getDeltaSeconds();
            },
            'status',
        ];
    }

    /**
     * @return \DateInterval|false
     */
    public function getDelta()
    {
        $create = date_create($this->created_at);
        $stopped = date_create($this->stopped_at);

        return date_diff($create, $stopped);
    }

    /**
     * @return int
     */
    public function getDeltaSeconds(): int
    {
        $create = date_create($this->created_at);
        $stopped = date_create($this->stopped_at);

        return $stopped->getTimestamp() - $create->getTimestamp();
    }

    /**
     * @return string[]
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => "Активен",
            self::STATUS_DISABLE => "Не активен",
        ];
    }

}
