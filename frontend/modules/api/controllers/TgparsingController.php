<?php

namespace frontend\modules\api\controllers;

use backend\modules\tgparsing\models\Tgparsing;

class TgparsingController extends ApiController
{
    /**
     *
     * @OA\Post(path="/tgparsing/create",
     *   summary="Добавить телеграм пост",
     *   description="Метод для создания телеграм поста",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TG parsing"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"channel_id", "channel_title", "content"},
     *          @OA\Property(
     *              property="channel_id",
     *              type="integer",
     *              description="Идентификатор канала",
     *          ),
     *          @OA\Property(
     *              property="channel_title",
     *              type="string",
     *              description="Заголовок канала",
     *          ),
     *          @OA\Property(
     *              property="content",
     *              type="string",
     *              description="Тело поста",
     *          ),
     *          @OA\Property(
     *              property="post_id",
     *              type="integer",
     *              description="Идентификатор поста",
     *          ),
     *          @OA\Property(
     *              property="channel_link",
     *              type="string",
     *              description="Ссылка на канал",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект поста",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Tgparsing"),
     *     ),
     *   ),
     * )
     *
     */
    public function actionCreate(): array|Tgparsing
    {
        $model = new Tgparsing();
        $request = \Yii::$app->request->post();

        $put = array_diff($request, [null, '']);

        $model->load($put, '');

        if (!$model->save()) {
            return $model->errors;
        }

        return $model;
    }

}
