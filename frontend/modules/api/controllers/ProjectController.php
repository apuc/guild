<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectTaskCategory;
use common\models\Status;
use common\models\User;
use common\models\UseStatus;
use frontend\modules\api\models\Manager;
use frontend\modules\api\models\project\Project;
use frontend\modules\api\models\project\ProjectStatistic;
use frontend\modules\api\models\project\ProjectUser;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
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
                    'add-user' => ['POST', 'OPTIONS'],
                    'update' => ['PUT', 'OPTIONS']
                ],
            ]
        ]);
    }

    /**
     *
     * @OA\Get(path="/project/get-project",
     *   summary="Получить данные проекта",
     *   description="Метод для получения проета<br>
    Статусы:<br>
    10 - Закрыт<br>
    19 - Работает",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *   @OA\Parameter(
     *      name="project_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *        default=null
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="expand",
     *      in="query",
     *      example="column,mark",
     *      required=false,
     *      description="В этом параметре по необходимости передаются поля, которые нужно добавить в ответ сервера, сейчас доступно только поле <b>columns</b> и <b>mark</b>",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов проекта",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Project"),
     *     ),
     *   ),
     * )
     *
     * @param $project_id
     * @return array|ActiveRecord|null
     */
    public function actionGetProject($project_id)
    {
        return Project::find()->with('columns')->where(['id' => $project_id])->one();
    }

    /**
     *
     * @OA\Get(path="/project/project-list",
     *   summary="Список проектов",
     *   description="Метод для получения списка проетов, если не передан параметр user_id, то возвращаются проеты текущего пользователя.<br>
    Статусы:<br>
    10 - Закрыт<br>
    19 - Работает",
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
     *   @OA\Parameter(
     *      name="expand",
     *      in="query",
     *      example="column,mark",
     *      required=false,
     *      description="В этом параметре по необходимости передаются поля, которые нужно добавить в ответ сервера, сейчас доступно только поле <b>columns</b> и <b>mark</b>",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *
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
        if (!$user_id) {
            $user_id = Yii::$app->user->id;
        }
        if (!empty($user_id)) {
            $projectIdList = ProjectUser::find()->where(['user_id' => $user_id])->select('project_id')->column();
            $query = Project::find()->where(['IN', 'id', $projectIdList])->orWhere(['owner_id' => $user_id, 'status' => Project::STATUS_OTHER]);
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
        $projectTaskCategory->attributes = \yii::$app->request->post();

        if ($projectTaskCategory->validate()) {
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

        if (empty($projectTaskCategory)) {
            throw new NotFoundHttpException('The project not found');
        }

        $projectTaskCategory->title = Yii::$app->request->post('new_title');
        if (!$projectTaskCategory->update() && $projectTaskCategory->hasErrors()) {
            return $projectTaskCategory->errors;
        }
        return $projectTaskCategory;
    }

    /**
     *
     * @OA\Post(path="/project/create",
     *   summary="Добавить проект",
     *   description="Метод для создания проекта, если не передан параметр <b>user_id</b>, то будет получен текущий пользователь<br>
    Статусы:<br>
    10 - Закрыт<br>
    19 - Работает",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"name", "status"},
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              description="Название проекта",
     *          ),
     *          @OA\Property(
     *              property="description",
     *              type="string",
     *              description="Описание проекта",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="статус",
     *          ),
     *          @OA\Property(
     *              property="company_id",
     *              type="integer",
     *              description="Компания к которой относится проект",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Проекта",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Project"),
     *     ),
     *   ),
     * )
     *
     * @return array|Project
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $project = new Project();
        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['Пользователь не найден']));
        }
        $project->load(\yii::$app->request->post(), '');
        $project->owner_id = $user_id;

        if ($project->validate()) {
            $project->save(false);
            return $project;
        }
        return $project->errors;
    }

    /**
     *
     * @OA\PUT(path="/project/update",
     *   summary="Редактировать проект",
     *   description="Метод для редактирования проекта<br>
    Статусы:<br>
    10 - Закрыт<br>
    19 - Работает",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"project_id"},
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              description="Название проекта",
     *          ),
     *          @OA\Property(
     *              property="description",
     *              type="string",
     *              description="Описание проекта",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="статус",
     *          ),
     *          @OA\Property(
     *              property="company_id",
     *              type="integer",
     *              description="Компания к которой относится проект",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Проекта",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Project"),
     *     ),
     *   ),
     * )
     *
     * @throws \Throwable
     * @throws InvalidConfigException
     * @throws \yii\db\StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request->getBodyParams();
        if (!isset($request['project_id']) || $request['project_id'] == null) {
            throw new BadRequestHttpException(json_encode(['The project ID not found']));
        }
        $project = Project::findOne($request['project_id']);
        if (empty($project)) {
            throw new NotFoundHttpException('The project not found');
        }

        $put = array_diff($request, [null, '']);
        $project->load($put, '');
        if (!$project->update()) {
            return $project->errors;
        }
        return $project;
    }

    /**
     *
     * @OA\Get(path="/project/my-employee",
     *   summary="Список Сотрудников текущего пользователя",
     *   description="Метод для получения списка сотрудников",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Менеджера",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ManagerEmployee"),
     *     ),
     *   ),
     * )
     *
     * @return array|ActiveRecord
     * @throws BadRequestHttpException
     */
    public function actionMyEmployee()
    {
        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['Пользователь не найден']));
        }

        $model = Manager::find()->with(['managerEmployees'])->where(['user_id' => $user_id])->one();

        if (!$model) {
            return [];
        }

        return $model;
    }

    /**
     *
     * @OA\Post(path="/project/add-user",
     *   summary="Добавить пользователя в проект",
     *   description="Метод для добавления пользователя в проект",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"user_id", "project_id"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *          ),
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectUsers"),
     *     ),
     *   ),
     * )
     *
     * @return array|ProjectUser
     * @throws NotFoundHttpException
     */
    public function actionAddUser()
    {
        $request = Yii::$app->request->post();
        $project = Project::findOne($request['project_id']);
        if (empty($project)) {
            throw new NotFoundHttpException('The project not found');
        }

        $model = new ProjectUser();
        $model->load($request, '');
        if (isset($model->user->userCard)) {
            $model->card_id = $model->user->userCard->id;
        }

        if (!$model->save()) {
            return $model->errors;
        }

        return $model;
    }

    /**
     *
     * @OA\Delete(path="/project/del-user",
     *   summary="Удаление пользователя из проекта",
     *   description="Метод для Удаления пользователя из проекта",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"project_id", "user_id"},
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект проекта",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Project"),
     *     ),
     *   ),
     * )
     *
     * @return Project
     * @throws InvalidConfigException|NotFoundHttpException
     */
    public function actionDelUser(): Project
    {
        $request = Yii::$app->request->getBodyParams();

        ProjectUser::deleteAll(['project_id' => $request['project_id'], 'user_id' => $request['user_id']]);
        $project = Project::findOne($request['project_id']);
        if (empty($project)) {
            throw new NotFoundHttpException('The project not found');
        }

        return $project;
    }

    /**
     *
     * @OA\Get(path="/project/statistic",
     *   summary="Получить статистику проекта",
     *   description="Метод для получения статистики проета",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *   @OA\Parameter(
     *      name="project_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *        default=null
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект статистики проекта",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectStatisticExample"),
     *     ),
     *   ),
     * )
     *
     * @param $project_id
     * @return array|ActiveRecord|null
     */
    public function actionStatistic($project_id): array|ActiveRecord|null
    {
        return ProjectStatistic::find()->where(['id' => $project_id])->one();
    }

    /**
     *
     * @OA\Post(path="/project/add-user-by-email",
     *   summary="Добавить пользователя в проект по почте",
     *   description="Метод для добавления пользователя в проект по почте",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"email", "project_id"},
     *          @OA\Property(
     *              property="email",
     *              type="integer",
     *              description="Email пользователя",
     *          ),
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectUsers"),
     *     ),
     *   ),
     * )
     *
     * @return ProjectUser
     * @throws NotFoundHttpException
     */
    public function actionAddUserByEmail(): ProjectUser
    {
        $request = Yii::$app->request->post();
        $project = Project::findOne($request['project_id']);
        if (empty($project)) {
            throw new NotFoundHttpException('The project not found');
        }

        $user = User::findByEmail($request['email']);
        if (empty($user)) {
            throw new NotFoundHttpException('The user not found');
        }

        $model = new ProjectUser();
        $model->user_id = $user->id;
        $model->project_id = $project->id;
        $model->save();

        return $model;
    }
}