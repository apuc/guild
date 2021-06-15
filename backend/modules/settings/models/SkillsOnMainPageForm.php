<?php


namespace backend\modules\settings\models;


use common\classes\Debug;
use common\models\Options;
use yii\base\Model;

/**
 * Class SkillsOnMainPageForm
 * @property array $skills_back
 * @property array $skills_front
 * @property array $skills_design
 * @package backend\modules\settings\models
 */
class SkillsOnMainPageForm extends Model
{

    public $skills_back;
    public $skills_front;
    public $skills_design;
    public $showMsg = false;

    public function rules()
    {
        return [
            [['skills_back', 'skills_front', 'skills_design'], 'checkIsArray'],
        ];
    }

    public function checkIsArray()
    {
        if (!is_array($this->_task)) {
            $this->addError('_task', 'X is not array!');
        }
    }

    public function saveSkills()
    {
        $res = [];
        $resToFront = [];
        if ($this->skills_back) {
            $res['SkillsOnMainPageForm']['skills_back'] = $this->skills_back;
            foreach ($this->skills_back as $item) {
                $resToFront['skills_back'][] = ['id' => $item, 'tags' => \common\models\Skill::getNameById($item)];
            }
        }
        if ($this->skills_front) {
            $res['SkillsOnMainPageForm']['skills_front'] = $this->skills_front;
            foreach ($this->skills_front as $item) {
                $resToFront['skills_front'][] = ['id' => $item, 'tags' => \common\models\Skill::getNameById($item)];
            }
        }
        if ($this->skills_design) {
            $res['SkillsOnMainPageForm']['skills_design'] = $this->skills_design;
            foreach ($this->skills_design as $item) {
                $resToFront['skills_design'][] = ['id' => $item, 'tags' => \common\models\Skill::getNameById($item)];
            }
        }

        Options::setValue('skills_on_main_page', json_encode($res));
        Options::setValue('skills_on_main_page_to_front', json_encode($resToFront));
    }

}