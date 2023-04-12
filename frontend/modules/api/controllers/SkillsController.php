<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\models\Options;
use common\models\Skill;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class SkillsController extends ApiController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $b = [
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
        ];

        return array_merge($parent, $b);
    }

    public function verbs(): array
    {
        return [
            'skills-on-main-page' => ['get'],
            'get-skills-list' => ['get'],
        ];
    }

    public function actionIndex()
    {
        return ['some' => 'rrr'];
    }

    /**
     *
     * @OA\Get(path="/skills/skills-on-main-page",
     *   summary="Получить список навыков для отображения на главной",
     *   description="Получить список навыков на главной странице",
     *   tags={"Skills"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив навыков",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *
     *   ),
     * )
     *
     * @return array|mixed
     */
    public function actionSkillsOnMainPage()
    {
        $data = \common\models\Options::getValue('skills_on_main_page_to_front');
        if ($data) $data = json_decode($data, true);
        else return [];

        return $data;
    }

    /**
     *
     * @OA\Get(path="/skills/get-skills-list",
     *   summary="Получить список навыков",
     *   description="Получить список навыков",
     *   tags={"Skills"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив навыков",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/SkillsExample"),
     *     ),
     *
     *   ),
     * )
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetSkillsList(): array
    {
        return Skill::find()->all();
    }

}
