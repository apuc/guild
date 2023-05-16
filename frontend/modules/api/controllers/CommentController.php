<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\Comment;
use yii\web\BadRequestHttpException;

class CommentController extends ApiController
{
    public function verbs(): array
    {
        return [
            'get-entity-type-list' => ['get'],
            'create' => ['post'],
            'update' => ['put', 'patch'],
        ];
    }

    /**
     *
     * @OA\Get(path="/comment/get-entity-type-list",
     *   summary="Список типов сущностей",
     *   description="Получить список всех возможных типов сущностей",
     *   tags={"Comment"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Проект",
     *                 ),
     *             )
     *         ),
     *     ),
     *
     *   ),
     * )
     *
     * @return array
     */
    public function actionGetEntityTypeList(): array
    {
        $arr = [];
        foreach (Comment::getEntityTypeList() as $key => $value) {
            $arr[] = ["id" => $key, "name" => $value];
        }

        return $arr;
    }

    /**
     *
     * @OA\Post(path="/comment/create",
     *   summary="Добавить комментарий",
     *   description="Метод для создания комментария",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Comment"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"text"},
     *          @OA\Property(
     *              property="text",
     *              type="string",
     *              description="Текст комментария",
     *          ),
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
     *         @OA\Schema(ref="#/components/schemas/Comment"),
     *     ),
     *   ),
     * )
     *
     * @return array|Comment
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $model = new Comment();
        $request = \Yii::$app->request->post();

        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['User not found']));
        }

        $request['user_id'] = $user_id;

        $model->load($request, '');

        if (!$model->save()) {
            return $model->errors;
        }

        return $model;
    }

    /**
     *
     * @OA\Put(path="/comment/update",
     *   summary="Редактировать комментария",
     *   description="Метод для редактирования комментария",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Comment"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"comment_id", "text"},
     *          @OA\Property(
     *              property="comment_id",
     *              type="integer",
     *              description="Идентификатор комментария",
     *          ),
     *          @OA\Property(
     *              property="text",
     *              type="string",
     *              description="Текст комментария",
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
     *     description="Возвращает объект Комментария",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Comment"),
     *     ),
     *   ),
     * )
     *
     * @return Comment
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(): Comment
    {
        $user_id = \Yii::$app->user->id;
        if (!$user_id) {
            throw new BadRequestHttpException(json_encode(['User not found']));
        }

        $comment_id = \Yii::$app->request->getBodyParam('comment_id');
        $model = Comment::findOne($comment_id);
        if (!$model) {
            throw new BadRequestHttpException(json_encode(['Comment not found']));
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
     * @OA\Get(path="/comment/get-by-entity",
     *   summary="Получить комментарии по идентификатору сущности",
     *   description="Метод для получения комментариев по идентификатору сущности.",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Comment"},
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
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов Комментариев",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/CommentExample"),
     *     ),
     *   ),
     * )
     *
     * @param int $entity_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetByEntity(int $entity_id): array
    {
        $model = Comment::find()->where(['entity_id' => $entity_id, 'status' => Comment::STATUS_ACTIVE])->all();

        return $model;
    }

}