<?php

namespace frontend\modules\api\models\resume\forms;
use yii\base\Model;

class ChangeResumeForm extends Model
{
    public $resume;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['resume'], 'string'],
            [['resume'], 'required'],
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
