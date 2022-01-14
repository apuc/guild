<?php

namespace frontend\modules\api\controllers;

use common\models\ManagerEmployee;
use common\models\User;
use common\models\UserCard;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;

class ManagerController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function verbs(): array
    {
        return [
            'get-manager' => ['get'],
            'get-employees-manager' => ['get'],
            'get-manager-list' => ['get'],
        ];
    }

    public function actionGetManagerList(): array
    {
        $managers = UserCard::find()->select(['fio','manager.id' , 'email'])
            ->joinWith('manager')->where(['NOT',['manager.user_card_id' => null]])->all();

        if(empty($managers)) {
            throw new NotFoundHttpException('Managers are not assigned');
        }

        return $managers;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetEmployeesManager()
    {
        $manager_id = Yii::$app->request->get('manager_id');
        if(empty($manager_id) or !is_numeric($manager_id))
        {
            throw new NotFoundHttpException('Incorrect manager ID');
        }

        $users_list = UserCard::find()
            ->select(['manager_employee.id', 'user_card.fio', 'user_card.email'])
            ->joinWith('managerEmployee')
            ->where(['manager_employee.manager_id' => $manager_id])
            ->all();

        if(empty($users_list)) {
            throw new NotFoundHttpException('Managers are not assigned or employees are not assigned to him');
        }

        return $users_list;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetManager(): array
    {
        $manager_id = Yii::$app->request->get('manager_id');
        if(empty($manager_id) or !is_numeric($manager_id))
        {
            throw new NotFoundHttpException('Incorrect manager ID');
        }

        $manager = UserCard::find()
            ->select(['manager.id', 'fio', 'email', 'photo', 'gender'])
            ->joinWith('manager')->where(['manager.id' => $manager_id])
            ->all();


        if(empty($manager)) {
            throw new NotFoundHttpException('There is no such manager');
        }

        return $manager;
    }
}