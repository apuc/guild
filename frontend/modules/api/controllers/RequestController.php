<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\Request;
use common\services\RequestService;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;


class RequestController extends ApiController
{

    public function verbs(): array
    {
        return [
            'get-request' => ['get'],
            'get-request-list' => ['get'],
            'create-request' => ['post'],
            'update-request' => ['put', 'patch'],
        ];
    }

    /**
     * @OA\Get(path="/request/get-request",
     *   summary="Получить запрос",
     *   description="Получения запроса по идентификатору",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Requests"},
     *   @OA\Parameter(
     *      name="request_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="search_depth",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *        type="integer",
     *        default=3
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Request"),
     *     ),
     *
     *   ),
     * )
     */
    public function actionGetRequest(int $request_id, int $search_depth = 3): Request
    {
        if (empty($request_id) or !is_numeric($request_id)) {
            throw new NotFoundHttpException('Incorrect request ID');
        }

        $requestService = RequestService::run($request_id);
        $model = $requestService->getById();

        if (empty($model)) {
            throw new NotFoundHttpException('The request does not exist');
        }

        $model->result_count = $requestService->search($search_depth)->count();
        $model->result_profiles = $requestService->all();


        return $model;
    }

    /**
     *
     * @OA\Get(path="/request/get-request-list",
     *   summary="Создать запрос",
     *   description="Метод для создания запроса, если параметр user_id не передан, то запрос создается от имени текущего пользователя.",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Requests"},
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
     *      name="search_depth",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *        type="integer",
     *        default=3
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/RequestsExample"),
     *     ),
     *   ),
     * )
     *
     * @param int|null $user_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetRequestList(int $user_id = null, int $search_depth = 3): array
    {
        if (!$user_id) {
            $user_id = \Yii::$app->user->id;
        }

        $requests = RequestService::run()->getByUserId($user_id);

        foreach ($requests as $request) {
            $requestService = RequestService::run($request->id);
            $request->result_count = $requestService->search($search_depth)->count();
            $request->result_profiles = $requestService->all();
        }

        return $requests;
    }

    /**
     *
     * @OA\Post(path="/request/create-request",
     *   summary="Добавить запрос",
     *   description="Метод для создания запроса, если не передан параметр <b>user_id</b>, то будет получен список текущего пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Requests"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"position_id", "title", "status"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Заголовок запроса",
     *          ),
     *          @OA\Property(
     *              property="position_id",
     *              type="integer",
     *              description="Позиция",
     *          ),
     *          @OA\Property(
     *              property="knowledge_level_id",
     *              type="integer",
     *              description="Уровень",
     *          ),
     *          @OA\Property(
     *              property="specialist_count",
     *              type="integer",
     *              description="Количество специалистов",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус запроса",
     *          ),
     *          @OA\Property(
     *              property="descr",
     *              type="string",
     *              description="Описание запроса",
     *          ),
     *          @OA\Property(
     *              property="skill_ids",
     *              type="array",
     *              description="Навыки",
     *              @OA\Items(
     *                  type="integer",
     *              ),
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Request"),
     *     ),
     *   ),
     * )
     *
     * @return Request
     * @throws BadRequestHttpException
     */
    public function actionCreateRequest(): Request
    {
        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['Пользователь не найден']));
        }

        $requestService = RequestService::run()
            ->setUserId($user_id)
            ->load(\Yii::$app->request->post(), '')
            ->save();

        if (!$requestService->isSave) {
            throw new BadRequestHttpException(json_encode($requestService->errors));
        }

        return $requestService->getModel();
    }

    /**
     *
     * @OA\Put(path="/request/update-request",
     *   summary="Редактировать запрос",
     *   description="Метод для редактирования запроса, если не передан параметр <b>user_id</b>, то будет получен список текущего пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Requests"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"request_id"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="request_id",
     *              type="integer",
     *              description="Идентификатор запросв",
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Заголовок запроса",
     *          ),
     *          @OA\Property(
     *              property="position_id",
     *              type="integer",
     *              description="Позиция",
     *          ),
     *          @OA\Property(
     *              property="knowledge_level_id",
     *              type="integer",
     *              description="Уровень",
     *          ),
     *          @OA\Property(
     *              property="specialist_count",
     *              type="integer",
     *              description="Количество специалистов",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус запроса",
     *          ),
     *          @OA\Property(
     *              property="descr",
     *              type="string",
     *              description="Описание запроса",
     *          ),
     *          @OA\Property(
     *              property="skill_ids",
     *              type="array",
     *              description="Навыки",
     *              @OA\Items(
     *                  type="integer",
     *              ),
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Request"),
     *     ),
     *   ),
     * )
     *
     * @return Request|null
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     */
    public function actionUpdateRequest(): Request
    {
        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['User not found']));
        }

        $request_id = \Yii::$app->request->getBodyParam('request_id');
        if (!$request_id) {
            throw new BadRequestHttpException(json_encode(['Request not found']));
        }

        $requestService = RequestService::run($request_id);

        if (!$requestService->validateUser($user_id)){
            throw new BadRequestHttpException(json_encode(['The user does not have the right to edit the request'], true));
        }

        $put = array_diff(\Yii::$app->request->getBodyParams(), [null, '']);

        $requestService->load($put, '')->save();

        if (!$requestService->isSave) {
            throw new BadRequestHttpException(json_encode($requestService->errors));
        }

        return $requestService->getModel();
    }

}