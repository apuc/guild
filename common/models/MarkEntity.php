<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mark_entity".
 *
 * @property int $id
 * @property int $mark_id
 * @property int $entity_type
 * @property int $entity_id
 */
class MarkEntity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mark_entity';
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'mark_id',
            'mark',
            'entity_type',
            'entity_id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark_id', 'entity_type', 'entity_id'], 'required'],
            [['mark_id', 'entity_type', 'entity_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark_id' => 'Mark ID',
            'entity_type' => 'Entity Type',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Mark::class, ['id' => 'mark_id']);
    }
}
