<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "use_field".
 *
 * @property int $id
 * @property int $field_id
 * @property int $use
 *
 * @property array $statuses
 * @property string $statusesText
 *
 * @property AdditionalFields $field
 */
class UseField extends \yii\db\ActiveRecord
{
    const USE_PROFILE = 0;
    const USE_PROJECT = 1;
    const USE_COMPANY = 2;
    const USE_BALANCE = 3;
    const USE_NOTE = 4;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'use_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'use'], 'required'],
            [['field_id', 'use'], 'integer'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdditionalFields::class, 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Поле',
            'use' => 'Применение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AdditionalFields::className(), ['id' => 'field_id']);
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
    public function getStatusesText()
    {
        return $this->statuses[$this->status_id];
    }

    /**
     * @return string status text label
     */
    public static function getStatusesTextById($id)
    {
        $model = new self();
        return $model->statuses[$id];
    }
}
