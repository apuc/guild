<?php

namespace frontend\modules\api\services;

use Exception;
use frontend\modules\api\models\LoginForm;
use frontend\modules\api\models\profile\ProfileChangeEmailForm;
use frontend\modules\api\models\profile\ProfileChangePasswordForm;
use frontend\modules\api\models\profile\ProfileChangePersonalDataForm;
use frontend\modules\api\models\profile\User;
use Yii;
use yii\web\BadRequestHttpException;

class UserService
{
    public function login(array $params)
    {
        $model = new LoginForm();
        $model->load($params, '');

        if ($model->load($params, '') && $model->login()) {
            /** @var User $user */
            $user = $model->getUser();
            return [
                'access_token' => $model->login(),
                'access_token_expired_at' => $model->getUser()->getTokenExpiredAt(),
                'id' => $user->id,
                'status' => $user->userCard->status ?? null,
                'card_id' => $user->userCard->id ?? null,
            ];
        } else {
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }

    public function findCurrentUser(): User
    {
        $user = User::findOne(Yii::$app->user->id);
        if (!$user){
            throw new BadRequestHttpException("User not found");
        }

        return $user;
    }
    /**
     * @throws Exception
     */
    public function changeChangePersonalData(array $params)
    {
        $form = new ProfileChangePersonalDataForm();
        $form->load($params);

        if (!$form->validate()){
            return $form;
        }

        $user = User::findOne(['id' => Yii::$app->user->identity->getId()]);;

        $user->username = $form->newUsername;
        if (!$user->save()) {
            throw new Exception('User dont save');
        }

        return ['status' => 'success'];
    }

    public function changeEmail(array $params)
    {
        $form = new ProfileChangeEmailForm();
        $form->load($params);

        if (!$form->validate()) {
            return $form;
        }

        $user = User::findOne(Yii::$app->user->identity->getId());
        $user->email = $form->newEmail;
        $user->save();

        return ['status' => 'success'];
    }

    public function changePassword(array $params)
    {
        $form = new ProfileChangePasswordForm();
        $form->load($params);

        if (!$form->validate()){
            return $form;
        }

        $user = User::findOne(Yii::$app->user->identity->getId());
        if ($user->validatePassword($form->password)) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($form->newPassword);
            $user->save();

            return ['status' => 'success'];
        }

        return ['error' => 'Wrong password!'];
    }
}