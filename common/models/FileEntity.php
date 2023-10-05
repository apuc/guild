<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "file_entity".
 *
 * @property int $id
 * @property int $file_id
 * @property int $entity_type
 * @property int $entity_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property File $file
 * @property EntityType $entityType
 */
class FileEntity extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

    const ENTITY_TYPE_TASK = 1;
    const ENTITY_TYPE_PROJECT = 2;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'file_id',
            'file',
            'entity_type',
            'entity_id',
            'created_at',
            'updated_at',
            'status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_entity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'entity_type', 'entity_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['entity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EntityType::className(), 'targetAttribute' => ['entity_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_id' => 'File ID',
            'entity_type_id' => 'Entity Type',
            'entity_id' => 'Entity ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityType()
    {
        return $this->hasOne(EntityType::className(), ['id' => 'entity_type_id']);
    }
}
