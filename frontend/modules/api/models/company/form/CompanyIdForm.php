<?php

namespace frontend\modules\api\models\company\form;

use frontend\modules\api\models\company\Company;
use yii\base\Model;

class CompanyIdForm extends Model
{
    public $company_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['company_id'], 'exist', 'skipOnError' => false, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }
}
