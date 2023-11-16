<?php

namespace frontend\modules\api\controllers;

use Exception;
use frontend\modules\api\models\questionnaire\forms\QuestionnaireUuidForm;
use frontend\modules\api\models\questionnaire\Question;
use frontend\modules\api\models\questionnaire\UserQuestionnaire;
use frontend\modules\api\services\UserQuestionnaireService;
use Yii;
use yii\web\BadRequestHttpException;

class QuestionController extends ApiController
{
    private UserQuestionnaireService $userQuestionnaireService;

    public function __construct(
        $id,
        $module,
        UserQuestionnaireService $userQuestionnaireService,
        $config = []
    )
    {
        $this->userQuestionnaireService = $userQuestionnaireService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @OA\Get(path="/question/get-questions",
     *   summary="Список вопросов",
     *   description="Получение списка вопросов и возможные варианты ответа. Сохраняет временную метку начала тестирования,
         от которой будет отсчитываться временной интервал на выполнение теста. При наличии лимита времени на выполнение теста.
         При превышении лимита времени на выполнение будет возвращена ошибка: Time's up!",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\Parameter(
     *      name="uuid",
     *      in="query",
     *      required=true,
     *     description="UUID анкеты назначеной пользователю",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает масив вопросов",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/QuestionExampleArr"),
     *     ),
     *
     *   ),
     * )
     *
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionGetQuestions(): array
    {
        $form = new QuestionnaireUuidForm();

        if ($form->load(Yii::$app->request->get()) && !$form->validate()) {
            $errors = $form->errors;
            throw new BadRequestHttpException(array_shift($errors)[0]);
        }

        $userQuestionnaire = UserQuestionnaire::findOne(['uuid' => $form->uuid]);

        if (!$this->userQuestionnaireService->checkTimeLimit($userQuestionnaire)) {
            UserQuestionnaireService::calculateScore($userQuestionnaire->uuid);
            throw new BadRequestHttpException("Time's up!");
        }

        return Question::activeQuestions($userQuestionnaire->questionnaire_id);
    }
}
