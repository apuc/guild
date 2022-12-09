<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\StaleObjectException;

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
 * @property CompanyManager $contractorManager
 * @property DocumentTemplate $template
 * @property CompanyManager $manager
 * @property DocumentFieldValue[] $documentFieldsValue
 */
class Document extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE_DOCUMENT_BODY = 'update_document_body';
    const SCENARIO_DOWNLOAD_DOCUMENT = 'download_document';
    const SCENARIO_PARTICIPANTS_OF_THE_TRANSACTION = "contract_participants";

    private $notRequiredFieldsSignature = [
        'company_id' => '${company}',
        'contractor_company_id' => '${contractor_company}',
        'manager_id' => '${manager}',
        'contractor_manager_id' => '${contractor_manager}',
    ];
    private $fieldPattern = '/\${(№?\s*\w*|(\w*\s?)*)}/';

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
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function beforeDelete()
    {
        $documentFieldsValue = $this->getDocumentFieldValues()->all();
        if ($documentFieldsValue) {
            foreach ($documentFieldsValue as $fieldValue){
                $fieldValue->delete();
            }
        }
        return parent::beforeDelete();
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $upAttributes = $this->getDirtyAttributes(['company_id', 'contractor_company_id', 'manager_id', 'contractor_manager_id', 'title']);
            $oldAttributes = $this->oldAttributes;


            //update dirty attributes in document body
            if ($oldAttributes && $upAttributes) {
                foreach ($upAttributes as $key => $value) {
                    if ($value != $oldAttributes[$key]) {

                        if ($key == 'company_id' || $key == 'contractor_company_id') {
                            $newValue = Company::getTitle($value);
                            $oldValue = $oldAttributes[$key] ? Company::getTitle($oldAttributes[$key]) : $key;
                        } elseif ($key == 'manager_id' || $key == 'contractor_manager_id') {
                            $newValue = CompanyManager::getName($value);
                            $oldValue = $oldAttributes[$key] ? CompanyManager::getName($oldAttributes[$key]) : $key;
                        } else {
                            $newValue = $this->title;
                            $oldValue = $oldAttributes[$key] ?? $key;
                        }

                        $this->body = str_replace($oldValue, $newValue, $this->body);
                    }
                }
            }


            //deleting fields value
            if ($this->isAttributeChanged('template_id', false)) {
                $documentFieldsValue = $this->getDocumentFieldValues()->all();
                foreach ($documentFieldsValue as $fieldValue){
                    $fieldValue->delete();
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'template_id'], 'required'],
            [['company_id', 'contractor_company_id', 'manager_id', 'contractor_manager_id', 'template_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['contractor_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['contractor_company_id' => 'id']],
            [['contractor_manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyManager::className(), 'targetAttribute' => ['contractor_manager_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyManager::className(), 'targetAttribute' => ['manager_id' => 'id']],
            ['body', 'required', 'on' => self::SCENARIO_UPDATE_DOCUMENT_BODY],
            ['body', 'checkBlankFields',  'on' => self::SCENARIO_DOWNLOAD_DOCUMENT ],
            [['company_id', 'contractor_company_id', 'manager_id', 'contractor_manager_id'], 'checkContractParticipants',  'skipOnEmpty'=> false, 'on' => self::SCENARIO_PARTICIPANTS_OF_THE_TRANSACTION],
            [['company_id', 'contractor_company_id'], 'checkCompanies',  'skipOnEmpty'=> false, 'on' => self::SCENARIO_PARTICIPANTS_OF_THE_TRANSACTION],
            [['contractor_manager_id', 'manager_id'], 'checkManagers',  'skipOnEmpty'=> false, 'on' => self::SCENARIO_PARTICIPANTS_OF_THE_TRANSACTION],
        ];
    }

    public function checkCompanies()
    {
        if ($this->company_id === $this->contractor_company_id && $this->company_id) {
            $this->addError('company_id', 'Компании и компания контрагент должны быть различны ');
            $this->addError('contractor_company_id', 'Компании и компания контрагент должны быть различны ');
        }
    }

    public function checkManagers()
    {
            if ($this->manager_id && $this->manager->userCard->id == $this->contractorManager->userCard->id) {
                $this->addError('manager_id', 'Менеджер и менеджер контрагент должны быть различными лицами');
                $this->addError('contractor_manager_id', 'Менеджер и менеджер контрагент должны быть различны лицами');
            }
    }

    public function checkBlankFields($attribute)
    {
        preg_match_all($this->fieldPattern, $this->$attribute,$out);
        if (!empty($out[0])) {
            $this->addError('body', 'В теле документа все переменные должны быть заменены!');
        }
    }

    public function checkContractParticipants($attribute)
    {
        if (str_contains($this->body, $this->notRequiredFieldsSignature[$attribute])) {
            $this->addError($attribute, 'Шаблоном требуется заполнить это поле');
        }
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
     * @return ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(DocumentTemplate::className(), ['id' => 'template_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getContractorCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'contractor_company_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getContractorManager()
    {
        return $this->hasOne(CompanyManager::className(), ['id' => 'contractor_manager_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(CompanyManager::className(), ['id' => 'manager_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDocumentFieldValues(): ActiveQuery
    {
        return $this->hasMany(DocumentFieldValue::className(), ['document_id' => 'id']);
    }

    public function getBlankFields()
    {
        preg_match_all($this->fieldPattern, $this->body,$out);
        return $out[0];
    }
}
