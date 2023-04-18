<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectTaskCategory;
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
                    'project-task-category-list' => ['GET', 'OPTIONS'],
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

    /**
     *
     * @OA\Get(path="/project/project-list",
     *   summary="Список проектов",
     *   description="Метод для получения списка проетов, если не передан параметр user_id, то возвращаются проеты текущего пользователя.",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *        type="integer",
     *        default=null
     *      )
     *   ),

     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов проекта",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectExample"),
     *     ),
     *   ),
     * )
     *
     * @param $user_id
     * @return ActiveDataProvider
     */
    public function actionProjectList($user_id = null): ActiveDataProvider
    {
        if (!$user_id){
            $user_id = Yii::$app->user->id;
        }
        if (!empty($user_id)) {
            $projectIdList = ProjectUser::find()->where(['user_id' => $user_id])->select('project_id')->column();
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

    public function actionProjectTaskCategoryList($project_id): array
    {
        return ProjectTaskCategory::find()->where(['project_id' => $project_id])->all();
    }

    public function actionCreateProjectTaskCategory()
    {
        $projectTaskCategory = new ProjectTaskCategory();
        $projectTaskCategory->attributes =  \yii::$app->request->post();

        if($projectTaskCategory->validate()) {
            $projectTaskCategory->save(false);
            return $projectTaskCategory;
        }
        return $projectTaskCategory->errors;
    }

    public function actionUpdateProjectTaskCategory()
    {
        $projectTaskCategory = ProjectTaskCategory::find()
            ->where(['project_id' => Yii::$app->request->post('project_id')])
            ->andWhere(['title' => Yii::$app->request->post('title')])
            ->one();

        if(empty($projectTaskCategory)) {
            throw new NotFoundHttpException('The project not found');
        }

        $projectTaskCategory->title = Yii::$app->request->post('new_title');
        if (!$projectTaskCategory->update() && $projectTaskCategory->hasErrors()) {
            return $projectTaskCategory->errors;
        }
        return $projectTaskCategory;
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