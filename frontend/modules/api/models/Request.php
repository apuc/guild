<?php

namespace frontend\modules\api\models;

/**
 * @OA\Schema(
 *  schema="Request",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=12,
 *     description="Идентификатор запроса"
 *  ),
 *  @OA\Property(
 *     property="title",
 *     type="string",
 *     example="PHP Developer",
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="created_at",
 *     type="datetime",
 *     example="2023-04-07 02:09:42",
 *     description="Дата и время создания"
 *  ),
 *  @OA\Property(
 *     property="updated_at",
 *     type="datetime",
 *     example="2023-04-10 16:20:48",
 *     description="Дата и время обновления"
 *  ),
 *  @OA\Property(
 *     property="user_id",
 *     type="integer",
 *     example=19,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="position_id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор позиции"
 *  ),
 *  @OA\Property(
 *     property="position",
 *     ref="#/components/schemas/Position"
 *  ),
 *  @OA\Property(
 *     property="skill_ids",
 *     type="array",
 *     @OA\Items(
 *         type="integer",
 *     ),
 *     example="[1,2]",
 *     description="Идентификаторы навыков"
 *  ),
 *  @OA\Property(
 *     property="knowledge_level_id",
 *     type="int",
 *     example=2,
 *     description="Идентификатор ровня разработчика"
 *  ),
 *  @OA\Property(
 *     property="descr",
 *     type="string",
 *     example="Необходим разрабочик со знанием PHP и Laravel",
 *     description="Идентификатор ровня разработчика"
 *  ),
 *  @OA\Property(
 *     property="specialist_count",
 *     type="int",
 *     example=2,
 *     description="Колличество необходимых специалистов"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example=1,
 *     description="Статус запроса"
 *  ),
 *  @OA\Property(
 *     property="skills",
 *     ref="#/components/schemas/SkillsExample",
 *  ),
 *  @OA\Property(
 *     property="result_count",
 *     type="int",
 *     example=6,
 *     description="Количество найденых профилей"
 *  ),
 *  @OA\Property(
 *     property="level",
 *     type="string",
 *     example="Middle",
 *     description="Текстовое наименование уровня знаний"
 *  ),
 *  @OA\Property(
 *     property="result_profiles",
 *     ref="#/components/schemas/RequestsProfileSearchExample",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="RequestsExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/Request",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="RequestsProfileSearchExample",
 *  type="array",
 *  example={
 *     {"id": 23, "fio": "Иванов Иван Иванович", "position_id": "1", "skill_id": "1"},
 *     {"id": 24, "fio": "Петров Петр Петрович", "position_id": "2", "skill_id": "1"}
 *  },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="fio",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="position_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="skill_id",
 *         type="integer",
 *      ),
 *  ),
 *)
 *
 */
class Request extends \common\models\Request
{

}