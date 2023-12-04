<?php

namespace frontend\modules\api\models\questionnaire\forms;

use frontend\modules\api\models\questionnaire\UserQuestionnaire;
use yii\base\Model;

class QuestionnaireUuidForm extends Model
{

    public $uuid;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['uuid'], 'string'],
            [['uuid'], 'required'],
            [['uuid'], 'exist', 'skipOnError' => false, 'targetClass' => UserQuestionnaire::class, 'targetAttribute' => ['uuid' => 'uuid']],
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
