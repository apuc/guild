<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use frontend\modules\api\models\Timer;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TimerController extends ApiController
{

    public function verbs(): array
    {
        return [
            'create' => ['post'],
            'update' => ['put'],
            'get-by-entity' => ['get'],
        ];
    }

    /**
     *
     * @OA\Post(path="/timer/create",
     *   summary="Добавить таймер",
     *   description="Метод для создания таймера",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Timer"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"entity_type", "entity_id", "created_at"},
     *          @OA\Property(
     *              property="entity_type",
     *              type="integer",
     *              description="Тип сущности",
     *          ),
     *          @OA\Property(
     *              property="entity_id",
     *              type="integer",
     *              description="Идентификатор сущности",
     *          ),
     *          @OA\Property(
     *              property="created_at",
     *              type="datetime",
     *              description="Время запуска. Формат (Год-месяц-день Час:минута:секунда). Пример: 2023-05-22 21:36:55",
     *              example="2023-05-22 21:36:55",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус комментария",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект комментария",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Timer"),
     *     ),
     *   ),
     * )
     *
     * @return Timer
     * @throws BadRequestHttpException
     */
    public function actionCreate(): Timer
    {
        $request = \Yii::$app->request->post();

        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException('User not found');
        }

        $request = array_diff($request, [null, '']);

        //Закрываем предыдущие таймеры
        $oldTimers = Timer::find()->where(['entity_id' => $request['entity_id'], 'entity_type' => $request['entity_type']])->all();
        if ($oldTimers){
            foreach ($oldTimers as $oldTimer){
                if ($oldTimer->stopped_at == null){
                    $oldTimer->stopped_at = date("Y-m-d H:i:s");
                    $oldTimer->save();
                }
            }
        }

        $model = new Timer();
        $model->load($request, '');
        $model->user_id = $user_id;
        $model->created_at = date("Y-m-d H:i:s");

        if (!$model->validate()) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        $model->save();

        return $model;
    }

    /**
     *
     * @OA\Put(path="/timer/update",
     *   summary="Редактировать таймер",
     *   description="Метод для редактирования таймера",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Timer"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"timer_id"},
     *          @OA\Property(
     *              property="timer_id",
     *              type="integer",
     *              description="Идентификатор таймера",
     *          ),
     *          @OA\Property(
     *              property="stopped_at",
     *              type="datetime",
     *              description="Время завершения работы таймера",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="статус",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Таймера",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Timer"),
     *     ),
     *   ),
     * )
     *
     * @return Timer
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(): Timer
    {
        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['User not found']));
        }

        $timer_id = \Yii::$app->request->getBodyParam('timer_id');
        $model = Timer::findOne($timer_id);
        if (!$model) {
            throw new BadRequestHttpException(json_encode(['Timer not found']));
        }

        $put = array_diff(\Yii::$app->request->getBodyParams(), [null, '']);
        $model->load($put, '');

        if(!$model->validate()){
            throw new BadRequestHttpException($model->errors);
        }
        $model->save();

        return $model;
    }

    /**
     *
     * @OA\Get(path="/timer/get-by-entity",
     *   summary="Получить таймер по идентификатору сущности",
     *   description="Метод для получения таймера по идентификатору сущности.",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Timer"},
     *   @OA\Parameter(
     *      name="entity_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *        default=null
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="entity_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *        default=null
     *      )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов Таймера",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/TimerExample"),
     *     ),
     *   ),
     * )
     *
     * @param int $entity_type
     * @param int $entity_id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetByEntity(int $entity_type, int $entity_id): array
    {
        $model = Timer::find()->where(['entity_type' => $entity_type, 'entity_id' => $entity_id, 'status' => Timer::STATUS_ACTIVE])->all();

        if (!$model) {
            throw new NotFoundHttpException('The timer not found');
        }

        return $model;

    }

}