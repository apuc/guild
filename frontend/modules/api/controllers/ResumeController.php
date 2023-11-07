<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\resume\Resume;
use Yii;

class ResumeController extends ApiController
{

    /**
     * @OA\Get(path="/resume",
     *   summary="Резюме пользователя",
     *   description="Получение резюме пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Resume"},
     *   @OA\Parameter(
     *      name="userId",
     *      description="Метод для получение резюме",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Резюме",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Resume"),
     *     ),
     *   ),
     * )
     *
     * @param int|null $userId
     * @return Resume|null
     */
    public function actionIndex(int $userId = null): ?Resume
    {
        return Resume::findOne($userId ?? Yii::$app->user->identity->id);
    }
}
