<?php

namespace frontend\modules\api\controllers;


use common\services\ManagerService;
use yii\web\NotFoundHttpException;

class ManagerController extends ApiController
{
    public function verbs(): array
    {
        return [
            'get-manager' => ['get'],
            'get-employees-manager' => ['get'],
            'get-manager-list' => ['get'],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetManagerList(): array
    {
        $managers = ManagerService::getManagerList();

        if(empty($managers)) {
            throw new NotFoundHttpException('Managers are not assigned');
        }

        return $managers;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetManagerEmployeesList($manager_id): array
    {
        if(empty($manager_id) or !is_numeric($manager_id))
        {
            throw new NotFoundHttpException('Incorrect manager ID');
        }

        $managerEmployeesList = ManagerService::getManagerEmployeesList($manager_id);

        if(empty($managerEmployeesList)) {
            throw new NotFoundHttpException('Managers are not assigned or employees are not assigned to him');
        }

        return $managerEmployeesList;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetManager($manager_id): array
    {
        if(empty($manager_id) or !is_numeric($manager_id))
        {
            throw new NotFoundHttpException('Incorrect manager ID');
        }

        $manager = ManagerService::getManager($manager_id);

        if(empty($manager)) {
            throw new NotFoundHttpException('There is no such manager');
        }

        return $manager;
    }
}