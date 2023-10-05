<?php

namespace frontend\modules\api\controllers;

use common\models\File;
use frontend\modules\api\models\Comment;
use frontend\modules\api\models\FileEntity;
use frontend\modules\api\models\Mark;
use frontend\modules\api\models\MarkEntity;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class MarkController extends ApiController
{

    public function verbs(): array
    {
        return [
            'create' => ['post'],
            'attach' => ['post'],
            'detach' => ['delete'],
            'update' => ['put', 'patch'],
        ];
    }

    /**
     *
     * @OA\Post(path="/mark/create",
     *   summary="Добавить метку",
     *   description="Метод для создания метки",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Mark"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"color", "title", "slug"},
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Описание метки",
     *          ),
     *          @OA\Property(
     *              property="slug",
     *              type="string",
     *              description="Ключ",
     *          ),
     *          @OA\Property(
     *              property="color",
     *              type="string",
     *              description="Цвет",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус метки",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект метки",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Mark"),
     *     ),
     *   ),
     * )
     *
     * @return array|Mark
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $model = new Mark();
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
     * @OA\Put(path="/mark/update",
     *   summary="Редактировать метку",
     *   description="Метод для редактирования метки",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Mark"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"mark_id"},
     *          @OA\Property(
     *              property="mark_id",
     *              type="integer",
     *              description="Идентификатор метки",
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Описание метки",
     *          ),
     *          @OA\Property(
     *              property="slug",
     *              type="string",
     *              description="Ключ",
     *          ),
     *          @OA\Property(
     *              property="color",
     *              type="string",
     *              description="Цвет",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус метки",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Метки",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Mark"),
     *     ),
     *   ),
     * )
     *
     * @return Mark
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(): Mark
    {

        $mark_id = \Yii::$app->request->getBodyParam('mark_id');
        $model = Mark::findOne($mark_id);
        if (!$model) {
            throw new BadRequestHttpException(json_encode(['Mark not found']));
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
     * @OA\Post(path="/mark/attach",
     *   summary="Прикрепить метку",
     *   description="Метод для прикрепления меток",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Mark"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"mark_id", "entity_type", "entity_id"},
     *          @OA\Property(
     *              property="mark_id",
     *              type="intager",
     *              example=232,
     *              description="Идентификатор метки",
     *          ),
     *          @OA\Property(
     *              property="entity_type",
     *              type="intager",
     *              example=2,
     *              description="Идентификатор типа сущности",
     *          ),
     *          @OA\Property(
     *              property="entity_id",
     *              type="intager",
     *              example=234,
     *              description="Идентификатор сущности",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект прикрепления",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/MarkEntity"),
     *     ),
     *   ),
     * )
     *
     * @return MarkEntity
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionAttach(): MarkEntity
    {
        $request = \Yii::$app->request->post();
        $mark = Mark::findOne($request['mark_id']);
        if (!$mark) {
            throw new NotFoundHttpException('Mark not found');
        }

        $markEntity = MarkEntity::findOne(['mark_id' => $request['mark_id'], 'entity_type' => $request['entity_type'], 'entity_id' => $request['entity_id']]);
        if ($markEntity) {
            throw new ServerErrorHttpException('Mark is already attached');
        }

        $markEntity = new MarkEntity();
        $markEntity->load($request, '');

        if (!$markEntity->validate()) {
            throw new ServerErrorHttpException(json_encode($markEntity->errors));
        }

        $markEntity->save();

        return $markEntity;
    }


    /**
     *
     * @OA\Delete (path="/mark/detach",
     *   summary="Открепить метку",
     *   description="Метод для открепления меток",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Mark"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"mark_id", "entity_type", "entity_id"},
     *          @OA\Property(
     *              property="mark_id",
     *              type="intager",
     *              example=232,
     *              description="Идентификатор метки",
     *          ),
     *          @OA\Property(
     *              property="entity_type",
     *              type="intager",
     *              example=2,
     *              description="Идентификатор типа сущности",
     *          ),
     *          @OA\Property(
     *              property="entity_id",
     *              type="intager",
     *              example=234,
     *              description="Идентификатор сущности",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект прикрепления",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/MarkEntity"),
     *     ),
     *   ),
     * )
     *
     * @return int
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionDetach(): int
    {
        $request = \Yii::$app->request->getBodyParams();
        $mark = Mark::findOne($request['mark_id']);
        if (!$mark) {
            throw new NotFoundHttpException('Mark not found');
        }

        $markEntity = MarkEntity::findOne(['mark_id' => $request['mark_id'], 'entity_type' => $request['entity_type'], 'entity_id' => $request['entity_id']]);
        if (!$markEntity) {
            throw new NotFoundHttpException('Mark attach not found');
        }
        //$fileEntity->load($request, '');
        $del = $markEntity->delete();

        if (!$del) {
            throw new ServerErrorHttpException(json_encode($markEntity->errors));
        }

        return $del;
    }

}