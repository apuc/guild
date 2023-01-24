<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectUser;
use common\models\Status;
use common\models\UseStatus;
use frontend\modules\api\models\Project;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProjectController extends ApiController
{
    public $modelClass = 'frontend\modules\api\models\Project';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'projects',
    ];

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'get-project' => ['GET', 'OPTIONS'],
                    'project-list' => ['GET', 'OPTIONS'],
                    'status-list' => ['GET', 'OPTIONS'],
                    'create' => ['POST', 'OPTIONS'],
                    'update' => ['POST', 'OPTIONS']
                ],
            ]
        ]);
    }

    public function actionGetProject($project_id): ?Project
    {
        return  Project::findOne($project_id);
    }

    public function actionProjectList($card_id = null): ActiveDataProvider
    {
        if (!empty($card_id)) {
            $projectIdList = ProjectUser::find()->where(['card_id' => $card_id])->select('project_id')->column();
            $query = Project::find()->where([ 'IN', 'id', $projectIdList]);
        } else {
            $query = Project::find();
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function actionStatusList(): array
    {
        return Status::find()
            ->joinWith('useStatuses')
            ->where(['`use_status`.`use`' => UseStatus::USE_PROJECT])->all();
    }

    public function actionCreate()
    {
        $project = new Project();
        $project->attributes =  \yii::$app->request->post();

        if($project->validate()) {
            $project->save(false);
            return $project;
        }
        return $project->errors;
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $project = Project::findOne(Yii::$app->request->post('project_id'));
        if(empty($project)) {
            throw new NotFoundHttpException('The project not found');
        }

        $project->load(Yii::$app->request->getBodyParams(), '');
        if (!$project->update()) {
            return $project->errors;
        }
        return $project;
    }
}