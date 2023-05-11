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

        if (!$model->save()){
            return $model->errors;
        }

        return $model;
    }

}