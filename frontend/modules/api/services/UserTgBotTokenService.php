<?php

namespace frontend\modules\api\services;


use common\classes\Debug;
use DateTime;
use Exception;
use frontend\modules\api\models\profile\User;
use frontend\modules\api\models\tg_bot\forms\TgBotDialogForm;
use frontend\modules\api\models\tg_bot\forms\UserTgBotLoginForm;
use frontend\modules\api\models\tg_bot\UserTgBotDialog;
use frontend\modules\api\models\tg_bot\UserTgBotToken;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class UserTgBotTokenService
{
    const CHARACTERS = '0123456789';


    public function auth(array $params): array
    {
        /** @var UserTgBotToken $model */
        $model = new UserTgBotLoginForm;

        if ($model->load($params, '') && $model->validate()) {

            $userTgBotToken = UserTgBotToken::findOne(['token' => $model->token]);
            $user = $userTgBotToken->user;
            return [
                'access_token' => $userTgBotToken->updateToken(),
                'access_token_expired_at' => $userTgBotToken->user->getTokenExpiredAt(),
                'id' => $user->id,
                'status' => $user->userCard->status ?? null,
                'card_id' => $user->userCard->id ?? null,
            ];
        } else {
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }

    /**
     * @param array $params
     * @return array|UserTgBotDialog|TgBotDialogForm
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function createDialog(array $params): array|UserTgBotDialog|TgBotDialogForm
    {
        $form = new TgBotDialogForm();
        $form->load($params);
        if (!$form->validate()){
            return $form->errors;
        }

        if ($this->hasDialog($form->dialog_id, $form->user_id)){
            return $this->getDialogById($form->dialog_id);
        }

        $dialog = new UserTgBotDialog();
        $dialog->user_id = $form->user_id;
        $dialog->dialog_id = $form->dialog_id;
        $dialog->username = $form->username;
        $dialog->first_name = $form->first_name;
        $dialog->last_name = $form->last_name;
        $dialog->key_words = $form->key_words;
        $dialog->status = $form->status;

        if (!$dialog->save()) {
            return ['status' => 'error', 'message' => $dialog->errors];
        }

        return $dialog;
    }

    /**
     * @param string $userId
     * @return array
     * @throws Exception
     */
    public function getDialogIdByUserId(string $userId): array
    {
        $model = UserTgBotDialog::findOne(['user_id' => $userId]);

        if (!$model) {
            throw new \Exception('dialog_id не найден!');
        }

        return ['dialog_id' => $model->dialog_id];
    }

    /**
     * @param int $dialog_id
     * @return UserTgBotDialog
     * @throws Exception
     */
    public function getDialogById(int $dialog_id): UserTgBotDialog
    {
        $model = UserTgBotDialog::findOne(['dialog_id' => $dialog_id]);

        if (!$model) {
            throw new \Exception('dialog не найден!');
        }

        return $model;
    }

    /**
     * @param int $dialog_id
     * @param int $user_id
     * @return array|UserTgBotDialog
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function setUserAtDialog(int $dialog_id, int $user_id): UserTgBotDialog|array
    {
        $model = UserTgBotDialog::findOne(['dialog_id' => $dialog_id]);

        if (!$model) {
            throw new \Exception('dialog не найден!');
        }

        $model->user_id = $user_id;
        if ($model->save()){
            return $model;
        }

        return $model->errors;
    }

    /**
     * @param string $dialogId
     * @return array
     * @throws Exception
     */
    public function getUserIdByDialogId(string $dialogId): array
    {
        $model = UserTgBotDialog::findOne(['dialog_id' => $dialogId]);

        if (!$model) {
            throw new \Exception('user_id не найден!');
        }

        return ['user_id' => $model->user_id];
    }

    /**
     * @param int $userId
     * @return UserTgBotToken
     * @throws Exception
     */
    public function getToken(int $userId): UserTgBotToken
    {
        $model = UserTgBotToken::findOne(['user_id' => $userId]);
        if (!empty($model)) {
            return $this->checkExpiredAtTime($model);
        }

        return $this->createToken($userId);
    }

    /**
     * @param string $token
     * @return User|string[]
     * @throws Exception
     */
    public function getUserByToken(string $token): array|User
    {
        $model = UserTgBotToken::findOne(['token' => $token]);
        if (!empty($model) ) {

            $currentTime = new DateTime();

            if ($currentTime < new DateTime($model->expired_at)) {
                return $model->user;
            } else {
                return ['error' => 'The token is expired!'];
            }

        }

        return ['error' => 'Token not found!'];
    }

    /**
     * @param int $dialog_id
     * @param int|null $user_id
     * @return bool
     */
    public function hasDialog(int $dialog_id, int $user_id = null): bool
    {
        $model = UserTgBotDialog::findOne(['user_id' => $user_id, 'dialog_id' => $dialog_id]);
        if ($model){
            return true;
        }

        return false;
    }


    /**
     * @return string
     * @throws Exception
     */
    private function generateToken(): string
    {
        $length = Yii::$app->params['tgBotTokenLength'];
        $charactersLength = strlen($this::CHARACTERS);
        do {
            $value = '';
            for ($i = 0; $i < $length; $i++) {
                $value .= $this::CHARACTERS[random_int(0, $charactersLength - 1)];
            }
        } while ( UserTgBotToken::checkExistsByToken($value));

        return $value;
    }

    /**
     * @param int $userId
     * @return UserTgBotToken
     * @throws Exception
     */
    private function createToken(int $userId): UserTgBotToken
    {
        $model = new UserTgBotToken();
        $model->user_id = $userId;
        $model->token = $this->generateToken();
        $model->expired_at = $this->generateExpiredAtTime();

        if (!$model->save()) {
            throw new \Exception('Токен не сохранен');
        }

        return $model;
    }

    /**
     * @return false|string
     */
    private function generateExpiredAtTime(): false|string
    {
        return date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) +  Yii::$app->params['tgBotTokenValidityTime']);
    }

    /**
     * @param UserTgBotToken $model
     * @return UserTgBotToken
     * @throws Exception
     */
    private function checkExpiredAtTime(UserTgBotToken $model): UserTgBotToken
    {
        $currentTime = new DateTime();

        if ($currentTime > new DateTime($model->expired_at)) {
            $this->updateExpiredAtTime($model);
        }

        return $model;
    }

    /**
     * @param UserTgBotToken $model
     * @return UserTgBotToken
     * @throws Exception
     */
    private function updateExpiredAtTime(UserTgBotToken $model): UserTgBotToken
    {
        $model->token = $this->generateToken();
        $model->expired_at = $this->generateExpiredAtTime();

        if (!$model->save()) {
            throw new \Exception('Токен не сохранен');
        }

        return $model;
    }


}