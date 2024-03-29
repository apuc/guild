<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectColumn;
use frontend\modules\api\models\project\Project;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ProjectColumnController extends ApiController
{
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
     * @return array|ActiveRecord[]
     * @throws BadRequestHttpException
     */
    public function actionGetColumnList($project_id): array
    {
        $project = Project::findOne($project_id);
        if (!$project) {
            throw new BadRequestHttpException(json_encode(['Проект не найден']));
        }

        $columns = \frontend\modules\api\models\project\ProjectColumn::find()->where(['project_id' => $project_id, 'status' => ProjectColumn::STATUS_ACTIVE])->all();

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
     * @return array|ProjectColumn|ActiveRecord|null
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

        if (!$column->validate()) {
            throw new BadRequestHttpException(json_encode($column->errors));
        }

        $column->save(false);

        return $column;
    }

    /**
     *
     * @OA\Post(path="/project-column/set-priority",
     *   summary="Установить приоритет колонок",
     *   description="Метод для установления приоритета колонок в проекте",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"project_id", "data"},
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="data",
     *              type="string",
     *              description="Данные для обновления приоритета. Пример: [{&quot;column_id&quot;:1,&quot;priority&quot;:2},{&quot;column_id&quot;:2,&quot;priority&quot;:3}]",
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
     * @return array|Project|ActiveRecord
     * @throws BadRequestHttpException
     */
    public function actionSetPriority()
    {
        $request = \Yii::$app->request->post();
        $data = $request['data'];

        $project = Project::findOne($request['project_id']);
        if (empty($project)) {
            throw new NotFoundHttpException('The project not found');
        }

        if (!$data = json_decode($data, true)) {
            throw new BadRequestHttpException('No valid JSON');
        }

        foreach ($data as $datum) {
            $model = ProjectColumn::findOne($datum['column_id']);
            $model->priority = $datum['priority'];
            if (!$model->validate()){
                throw new BadRequestHttpException($model->errors);
            }
            $model->save();
        }

        return $project;
    }

}