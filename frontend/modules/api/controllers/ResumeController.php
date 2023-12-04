<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\resume\forms\ChangeResumeForm;
use frontend\modules\api\models\resume\Resume;
use frontend\modules\api\services\ResumeService;
use Yii;
use yii\web\BadRequestHttpException;

class ResumeController extends ApiController
{
    public ResumeService $resumeService;

    public function __construct(
        $id,
        $module,
        ResumeService $resumeService,
        $config = []
    )
    {
        $this->resumeService = $resumeService;
        parent::__construct($id, $module, $config);
    }

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
     *      description="Метод для получение резюме. userId - обязателен, в случае его отсудствия будет возвращено резюме текущего пользователя",
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

    /**
     *
     * @OA\Put(path="/resume/edit-skills",
     *   summary="Изменить скилы",
     *   description="Метод полностью удалит старые скилы и используя переданые id скилов запишет новые",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Resume"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="json",
     *       @OA\Schema(
     *          required={"UserCard"},
     *          @OA\Property(
     *              property="UserCard",
     *              type="object",
     *              @OA\Property(
     *                   property="skill",
     *                   type="array",
     *                   @OA\Items(
     *                      type="integer",
     *                      example={1,2,3,4}
     *                   ),
     *         ),
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *   ),
     * )
     * )
     *
     * @return array|ChangeResumeForm
     * @throws BadRequestHttpException
     */
    public function actionEditSkills()
    {
        return $this->resumeService->editSkills(Yii::$app->request->post(), Yii::$app->user->identity->getId());
    }

    /**
     *
     * @OA\Put(path="/resume/edit-text",
     *   summary="Изменить резюме",
     *   description="Метод для изменения текста резюме",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Resume"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"resume"},
     *          @OA\Property(
     *              property="resume",
     *              type="string",
     *              description="Текст резюме",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *   ),
     * )
     * )
     *
     * @return array|ChangeResumeForm
     * @throws BadRequestHttpException
     */
    public function actionEditText(): ChangeResumeForm|array
    {
        return $this->resumeService->editText(Yii::$app->request->post(), Yii::$app->user->identity->getId());
    }
}
