<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fields_value".
 *
 * @property int $id
 * @property int $card_id
 * @property int $field_id
 * @property string $value
 * @property int $order
 * @property int $project_id
 * @property int $company_id
 *
 * @property AdditionalFields $field
 * @property Company $company
 * @property Project $project
 * @property UserCard $card
 */
class FieldsValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'value'], 'required'],
            [['card_id', 'field_id', 'order', 'project_id', 'company_id','balance_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdditionalFields::class, 'targetAttribute' => ['field_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::class, 'targetAttribute' => ['card_id' => 'id']],
            [['balance_id'],'exist', 'skipOnError' => true, 'targetClass' => Balance::class, 'targetAttribute' => ['balance_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'field_id' => 'Field ID',
            'value' => 'Value',
            'project_id' => 'Project ID',
            'company_id' => 'Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AdditionalFields::class, ['id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(UserCard::class, ['id' => 'card_id']);
    }
}
