<?php

namespace frontend\modules\api\controllers;

use common\models\Reports;
use common\models\ReportsTask;
use common\models\UserCard;
use DateTime;
use frontend\modules\api\models\ReportSearchForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ReportsController extends ApiController
{
    public function actionIndex($user_card_id)
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        $reportsModel->attributes = $params;

        $reportsModel->limit = $params['limit'] ?? $reportsModel->limit;
        $reportsModel->offset = $params['offset'] ?? $reportsModel->offset;

        if(!$reportsModel->validate()){
            return $reportsModel->errors;
        }

        return  $reportsModel->byParams();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionFindByDate()//: array
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        if(!isset($params['user_card_id']) or !isset($params['date'])){
            throw new NotFoundHttpException('Required parameter are missing!');
        }

        $reportsModel->attributes = $params;
        $reportsModel->date = $params['date'];

        if (!$this->checkDate($reportsModel->date)) {
            throw new BadRequestHttpException('Wrong date format');
        }

        if(!$reportsModel->validate()){
            return $reportsModel->errors;
        }

        return $reportsModel->findByDate();
    }

    public function actionCreate()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['tasks'])){
            throw new BadRequestHttpException('Нет параметра tasks');
        }

        if(!isset($params['user_card_id'])){
            $userCard = UserCard::find()->where(['id_user' => Yii::$app->user->id])->one();
            if($userCard){
                $params['user_card_id'] = $userCard->id;
            }
        }

        $reportsModel = new Reports();
        $reportsModel->attributes = $params;
        if(!$reportsModel->validate() || !$reportsModel->save()){
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $tasks = $params['tasks'];
        foreach ($tasks as $task) {
            $reportsTask = new ReportsTask();
            $reportsTask->attributes = $task;
            $reportsTask->report_id = $reportsModel->id;
            $reportsTask->created_at = $reportsTask->created_at ?? strtotime($reportsModel->created_at);
            $reportsTask->status = $reportsTask->status ?? 1;

            if(!$reportsTask->validate() || !$reportsTask->save()){
                throw new BadRequestHttpException(json_encode($reportsTask->errors));
            }
        }

        return array_merge($reportsModel->toArray());
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');

        $report = Reports::findOne($id);

        if(null === $report) {
            throw new NotFoundHttpException('Report not found');
        }

        if(false === ($report->delete())) {
            throw new \RuntimeException('Report not deleted');
        }

        return true;
    }

    public function actionUpdate(): array
    {
        $params = Yii::$app->request->get();

        $reportsModel = Reports::findone($params['id']);
        if(!isset($reportsModel)) {
            throw new NotFoundHttpException('report not found');
        }

        if(isset($params['user_card_id'])) {
            throw new \RuntimeException('constraint by user_card_id');
        }

        $reportsModel->attributes = $params;

        if(!$reportsModel->validate()){
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $reportsModel->save();

        return $reportsModel->toArray();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionReportsByDate($fromDate, $toDate, $user_card_id = null)
    {
        if (!$this->checkDate($fromDate) || !$this->checkDate($toDate)) {
            throw new BadRequestHttpException('Wrong date format');
        }

        $params = Yii::$app->request->get();
        $userId = $user_card_id ?? Yii::$app->user->id;
        /** @var UserCard $userCard */
        $userCard = UserCard::find()->where(['id_user' => $userId])->one();

        if (!$userCard) {
            throw new NotFoundHttpException('User not found');
        }

        $reportsModel = new ReportSearchForm();
        $reportsModel->attributes = $params;
        $reportsModel->user_card_id = $userCard->id;

        $reports = $reportsModel->reportsByDate();
        return $reportsModel;
        return ArrayHelper::toArray($reports , [
            'common\models\Reports' => [
                'date' => 'created_at',
                'id',
                'spendTime' => function (Reports $report) {
                    return $report->calculateOrderTime();
                },
            ],
        ]);
    }

    private function checkDate($date): bool
    {
        $checkedDate = DateTime::createFromFormat('Y-m-d', $date);
        $date_errors = DateTime::getLastErrors();
        if (!empty($date_errors['warning_count']) || !empty($date_errors['error_count'])) {
            return false;
        }
        return true;
    }

}
