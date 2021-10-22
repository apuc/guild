<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $id
 * @property string $label
 * @property string $key
 * @property string $value
 * @property int $status
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value'], 'string'],
            [['status'], 'integer'],
            [['label', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'key' => 'Key',
            'value' => 'Value',
            'status' => 'Status',
        ];
    }

    /**
     * @param $key
     * @return string|null
     */
    public static function getValue($key)
    {
        $value = self::find()->where(['key' => $key])->one();
        if ($value){
            return $value->value;
        }
        return null;
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public static function setValue($key, $value)
    {
        $model = self::find()->where(['key' => $key])->one();
        if(!$model) {
            $model = new self();
            $model->key = $key;
        }
        $model->value = $value;

        return $model->save();
    }
}
