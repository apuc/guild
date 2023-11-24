<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\company\form\CompanyIdForm;
use frontend\modules\api\services\PersonnelService;
use Yii;

class CompanyController extends ApiController
{
    public PersonnelService $personnelService;

    public function __construct(
        $id,
        $module,
        PersonnelService $personnelService,
        $config = []
    )
    {
        $this->personnelService = $personnelService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @OA\Get(path="/company/get-personal",
     *   summary="Персонал компании",
     *   description="Метод для получения персонала компании",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Company"},
     *   @OA\Parameter(
     *      name="company_id",
     *      description="ID компании",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает масив объектов сотрудников",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/CompanyPersonnelDtoExampleArr"),
     *     ),
     *   ),
     * )
     *
     * @return CompanyIdForm|array
     */
    public function actionGetPersonal(): CompanyIdForm|array
    {
        return $this->personnelService->getPersonnel(Yii::$app->request->get());
    }
}