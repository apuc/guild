<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $company_id
 * @property int $contractor_company_id
 * @property int $manager_id
 * @property int $contractor_manager_id
 *
 * @property Company $company
 * @property Company $contractorCompany
 * @property Manager $contractorManager
 * @property Manager $manager
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'manager_id', 'contractor_manager_id'], 'required'],
            [['company_id', 'contractor_company_id', 'manager_id', 'contractor_manager_id'], 'integer'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['contractor_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['contractor_company_id' => 'id']],
            [['contractor_manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['contractor_manager_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'contractor_company_id' => 'Contractor Company ID',
            'manager_id' => 'Manager ID',
            'contractor_manager_id' => 'Contractor Manager ID',
        ];
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
    public function getContractorCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'contractor_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContractorManager()
    {
        return $this->hasOne(Manager::className(), ['id' => 'contractor_manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['id' => 'manager_id']);
    }
}
