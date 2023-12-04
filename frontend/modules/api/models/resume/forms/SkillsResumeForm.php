<?php

namespace frontend\modules\api\models\resume\forms;
use frontend\modules\api\models\Skill;
use yii\base\Model;

class SkillsResumeForm extends Model
{
    public array $skill;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['skill'], 'required'],
            ['skill', 'each', 'rule' => ['integer']],
            ['skill', 'each', 'rule' => ['in', 'range' =>  Skill::find()->select('id')->column()]]
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
