<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectColumn;
use frontend\modules\api\models\Project;
use yii\web\BadRequestHttpException;

class ProjectColumnController extends ApiController
{

    public function verbs(): array
    {
        return [
            'get-column' => ['get'],
            'get-column-list' => ['get'],
            'create-column' => ['post'],
            'update-column' => ['put', 'patch'],
        ];
    }

    public function actionGetColumn()
    {

    }

    /**
     *
     * @OA\Get(path="/project-column/get-column-list",
     *   summary="Получить список колнок по проекту",
     *   description="Метод для получения колонок по проекту",
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
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов Колонка",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectColumnExample"),
     *     ),
     *   ),
     * )
     *
     * @param $project_id
     * @return array|\yii\db\ActiveRecord[]
     * @throws BadRequestHttpException
     */
    public function actionGetColumnList($project_id)
    {
        $project = Project::findOne($project_id);
        if (!$project) {
            throw new BadRequestHttpException(json_encode(['Проект не найден']));
        }

        $columns = \frontend\modules\api\models\ProjectColumn::find()->where(['project_id' => $project_id, 'status' => ProjectColumn::STATUS_ACTIVE])->all();

        return $columns;

    }

    /**
     *
     * @OA\Post(path="/project-column/create-column",
     *   summary="Добавить колонку",
     *   description="Метод для создания колонки",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"project_id", "title"},
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Название колонки",
     *          ),
     *          @OA\Property(
     *              property="priority",
     *              type="integer",
     *              description="Приоритет колонки",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект колонки",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectColumn"),
     *     ),
     *   ),
     * )
     *
     * @return array|ProjectColumn
     */
    public function actionCreateColumn()
    {
        $column = new ProjectColumn();
        $column->load(\Yii::$app->request->post(), '');

        if ($column->validate()) {
            $column->save(false);
            return $column;
        }
        return $column->errors;

    }

    /**
     *
     * @OA\Put(path="/project-column/update-column",
     *   summary="Редактировать колонку",
     *   description="Метод для редактирования колонки",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"column_id"},
     *          @OA\Property(
     *              property="column_id",
     *              type="integer",
     *              description="Идентификатор колонки",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Название колонки",
     *          ),
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="priority",
     *              type="integer",
     *              description="Приоритет колонки",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус колонки",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Колонки",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectColumn"),
     *     ),
     *   ),
     * )
     *
     * @return array|ProjectColumn|\yii\db\ActiveRecord|null
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateColumn()
    {
        $column_id = \Yii::$app->request->getBodyParam('column_id');
        if (!$column_id) {
            throw new BadRequestHttpException(json_encode(['Column not found']));
        }

        $column = ProjectColumn::find()->where(['id' => $column_id, 'status' => ProjectColumn::STATUS_ACTIVE])->one();

        $put = array_diff(\Yii::$app->request->getBodyParams(), [null, '']);

        $column->load($put, '');

        if (!$column->validate()){
            throw new BadRequestHttpException(json_encode($column->errors));
        }

        $column->save(false);

        return $column;
    }

}