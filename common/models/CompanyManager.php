<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company_manager".
 *
 * @property int $id
 * @property int $company_id
 * @property int $user_card_id
 *
 * @property Company $company
 * @property UserCard $userCard
 */
class CompanyManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'user_card_id'], 'required'],
            [['company_id', 'user_card_id'], 'integer'],
            ['user_card_id', 'unique', 'targetAttribute' => ['company_id', 'user_card_id'], 'message'=>'Этот менеджер уже закреплён за компанией'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['user_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['user_card_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'user_card_id' => 'Менеджер',
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
    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'user_card_id']);
    }

    public static function getManagersByCompany($company_id): array
    {
        return self::find()->where(['company_id' => $company_id])->all();
    }
}
