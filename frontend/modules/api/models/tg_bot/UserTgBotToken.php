<?php

namespace frontend\modules\api\models\tg_bot;


use frontend\modules\api\models\profile\User;
use yii\db\ActiveQuery;

/**
 *
 * @OA\Schema(
 *  schema="UserTgBotToken",
 *  @OA\Property(
 *     property="token",
 *     type="string",
 *     example= "HDAS7J",
 *     description="Токен ТГ бота"
 *  ),
 *  @OA\Property(
 *     property="expired_at",
 *     type="dateTime",
 *     example="2023-10-24 10:05:54",
 *     description="Время истечения активности токена"
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *  schema="UserTgBotTokenExample",
 *      @OA\Property(
 *         property="token",
 *         type="string",
 *         example="HDAS7J"
 *      ),
 *      @OA\Property(
 *         property="expired_at",
 *         type="dateTime",
 *         example="2023-10-24 10:05:54"
 *      ),
 *)
 *
 *  @property User $user
 */
class UserTgBotToken extends \common\models\UserTgBotToken
{
    public function fields(): array
    {
        return [
            'token',
            'expired_at',
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}