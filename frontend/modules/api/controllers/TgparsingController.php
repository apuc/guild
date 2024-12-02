<?php

namespace frontend\modules\api\controllers;

use backend\modules\tgparsing\models\Tgparsing;
use common\classes\Debug;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\web\ServerErrorHttpException;

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

    /**
     *
     * @OA\Get(path="/tgparsing/get-to-send",
     *   summary="Получить пост для отправки ботом",
     *   description="Метод для получения поста, возвращает один пост со статусом 'Готов к отправке' ",
     *   tags={"TG parsing"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает один пост",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Tgparsing"),
     *     ),
     *
     *   ),
     * )
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function actionGetToSend(): array|\yii\db\ActiveRecord|null
    {
        $post = Tgparsing::find()->where(['status' => Tgparsing::STATUS_READY_TO_SEND])->orderBy('id ASC')->one();
        $post->status = \common\models\Tgparsing::STATUS_SENT;
        $post->save();
        
        return $post;
    }


    public function actionAdminGetToSend(): array|\yii\db\ActiveRecord|null
    {
        $post = Tgparsing::find()->where(['status' => Tgparsing::STATUS_NEW])->orderBy('id ASC')->one();
        $post->status = Tgparsing::STATUS_SENT_TO_ADMIN;
        $post->save();
        return $post;
    }

    /**
     *
     * @OA\Get(path="/tgparsing/get-by-id",
     *   summary="Получить пост по идентификатору",
     *   description="Метод для получения постапо идентификатору",
     *   tags={"TG parsing"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Parameter(
     *       name="id",
     *       description="Идентификатор поста",
     *       in="query",
     *       required=true,
     *       @OA\Schema(
     *         type="integer",
     *       )
     *    ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает один пост",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Tgparsing"),
     *     ),
     *
     *   ),
     * )
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function actionGetById($id): ?Tgparsing
    {
        return Tgparsing::findOne($id);
    }

    /**
     *
     * @OA\Put(path="/tgparsing/update",
     *   summary="Редактировать телеграм пост",
     *   description="Метод для редактирования телеграм поста",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TG parsing"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"id"},
     *          @OA\Property(
     *              property="id",
     *              type="integer",
     *              description="Идентификатор записи",
     *          ),
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
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус поста",
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
     * @throws Exception
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(): ?Tgparsing
    {
        $params = array_diff(\Yii::$app->request->getBodyParams(), [null, '']);
        $model = Tgparsing::findOne($params['id']);
        $model->load($params, '');
        $model->save();

        if (!empty($model->hasErrors())) {
            throw new ServerErrorHttpException(json_encode($model->errors));
        }

        return $model;
    }

}
