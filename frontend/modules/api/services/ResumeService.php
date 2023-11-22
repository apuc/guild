<?php

namespace frontend\modules\api\services;

use frontend\modules\api\models\resume\forms\ChangeResumeForm;
use frontend\modules\api\models\resume\forms\SkillsResumeForm;
use frontend\modules\card\models\UserCard;
use yii\web\BadRequestHttpException;

class ResumeService
{
    /**
     * @param array $params
     * @param int $userId
     * @return SkillsResumeForm|string[]
     * @throws BadRequestHttpException
     */
    public function editSkills(array $params, int $userId): array|SkillsResumeForm
    {
        $model = new SkillsResumeForm();
        $model->load($params['UserCard']);

        if (!$model->validate()) {
            return $model;
        }

        $card = UserCard::findOne(['id_user' => $userId]);


        if (!$card->save()) {
            $errors = $card->getErrors();
            throw new BadRequestHttpException(array_shift($errors)[0]);
        }

        return ['status' => 'success'];

    }

    /**
     * @param array $params
     * @param int $userId
     * @return array|ChangeResumeForm
     * @throws BadRequestHttpException
     */
    public function editText(array $params, int $userId): array|ChangeResumeForm
    {
        $model = new ChangeResumeForm();
        $model->load($params);

        if (!$model->validate()) {
            return $model;
        }

        $card = UserCard::findOne(['id_user' => $userId]);
        $card->vc_text = $model->resume;

        if (!$card->save()) {
            $errors = $card->getErrors();
            throw new BadRequestHttpException(array_shift($errors)[0]);
        }

        return ['status' => 'success'];
    }
}