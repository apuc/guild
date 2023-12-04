<?php

namespace frontend\modules\api\services;

use frontend\modules\api\models\company\form\CompanyIdForm;
use frontend\modules\api\models\company\mappers\CompanyPersonnelMapper;
use frontend\modules\api\models\project\Project;

class PersonnelService
{
    /**
     * @param array $params
     * @return array|CompanyIdForm
     */
    public function getPersonnel(array $params): CompanyIdForm|array
    {
        $form = new CompanyIdForm();
        $form->load($params);

        if (!$form->validate()){
            return $form;
        }

        $projects = Project::find()->where(['company_id' => $form->company_id])->all();

        $personals = [];

        /** @var Project $project */
        foreach ($projects as $project) {
            $personals += CompanyPersonnelMapper::mapAll($project->projectUsers);
        }

        return $personals;
    }
}