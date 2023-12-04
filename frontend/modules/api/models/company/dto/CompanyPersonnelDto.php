<?php

namespace frontend\modules\api\models\company\dto;

/**
 *
 * @OA\Schema(
 *  schema="CompanyPersonnelDto",
 *  @OA\Property(
 *     property="userId",
 *     type="int",
 *     example=95,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="fio",
 *     type="string",
 *     example="Кочетков Валерий Александрович",
 *     description="ФИО пользователя"
 *  ),
 *  @OA\Property(
 *     property="position",
 *     type="string",
 *     example="Back end разработчик",
 *     description="Должность пользователя"
 *  ),
 *  @OA\Property(
 *     property="level",
 *     type="int",
 *     example="Middle",
 *     description="Уровень компетенций"
 *  ),
 *  @OA\Property(
 *     property="projectName",
 *     type="string",
 *     example="Проект 1",
 *     description="Название проекта на котором работает"
 *  ),
 *  @OA\Property(
 *     property="openTaskCount",
 *     type="int",
 *     example="5",
 *     description="Количество открытых задач на проекте"
 *  ),
 *  @OA\Property(
 *     property="hoursWorkedForCurrentMonth",
 *     type="int",
 *     example="5",
 *     description="Количество часов отработанных в текущем месяце"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="CompanyPersonnelDtoExampleArr",
 *  type="array",
 *  example={
 *     {"userId": 23, "fio": "Кочетков Валерий Александрович", "position": "Back end разработчик", "level": 2, "projectName": "Проект 1", "openTaskCount": 4, "hoursWorkedForCurrentMonth": 30},
 *     {"userId": 16, "fio": "Шишкина Милана Андреевна", "position": "Back end разработчик", "level": 1, "projectName": "Проект 2", "openTaskCount": 8, "hoursWorkedForCurrentMonth": 15},
 *  },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="userId",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="fio",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="position",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="level",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="projectName",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="openTaskCount",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="hoursWorkedForCurrentMonth",
 *         type="integer",
 *      ),
 *  ),
 *)
 *
 *
 *
 */
class CompanyPersonnelDto
{
    public $userId;
    public $fio;
    public $position;
    public $level;
    public $projectName;
    public $openTaskCount;
    public $hoursWorkedForCurrentMonth;
}

