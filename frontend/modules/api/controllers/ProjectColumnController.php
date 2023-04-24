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

        $columns = \frontend\modules\api\models\ProjectColumn::find()->where(['project_id' => $project_id])->all();

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

    public function actionUpdateColumn()
    {

    }

}