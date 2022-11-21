<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $company_id
 * @property int $contractor_company_id
 * @property int $manager_id
 * @property int $contractor_manager_id
 * @property int $template_id
 * @property string $title
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 * @property Company $contractorCompany
 * @property Manager $contractorManager
 * @property DocumentTemplate $template
 * @property Manager $manager
 */
class Document extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE_DOCUMENT_BODY = 'update_document_body';
    const SCENARIO_DOWNLOAD_DOCUMENT = 'download_document';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'contractor_company_id', 'manager_id', 'contractor_manager_id', 'title', 'template_id'], 'required'],
            [['company_id', 'contractor_company_id', 'manager_id', 'contractor_manager_id', 'template_id'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['contractor_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['contractor_company_id' => 'id']],
            [['contractor_manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['contractor_manager_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['manager_id' => 'id']],
            ['body', 'required', 'on' => self::SCENARIO_UPDATE_DOCUMENT_BODY],
            ['body', function ($attribute, $params) {
                    preg_match_all('/(\${\w+})/', $this->$attribute,$out);
                    if (!empty($out[0])) {
                        $this->addError('body', 'В теле документа все переменные должны бвть заменены!');
                    }
                },  'on' => self::SCENARIO_DOWNLOAD_DOCUMENT
            ],
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
            'contractor_company_id' => 'Компания контрагент',
            'manager_id' => 'Менеджер',
            'contractor_manager_id' => 'Менеджер контрагент',
            'template_id' => 'Шаблон документа',
            'title' => 'Название',
            'body' => 'Тело документа',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(DocumentTemplate::className(), ['id' => 'template_id']);
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
