<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Документация Гильдия",
 *      description="Документация для работы с API",
 *
 * ),
 *  @OA\PathItem(
 *         path="/api"
 *  ),
 * @OA\Server(
 *   url="https://itguild.info/api",
 *   description="Основной сервер",
 * ),
 *
 * @OA\Server(
 *   url="http://guild.loc/api",
 *   description="Локальный сервер",
 * ),
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="Authorization",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * ),
 */
class ApiController extends Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => GsCors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    //'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Allow-Headers' => [
                        'Access-Control-Allow-Origin',
                        'Content-Type',
                        'Access-Control-Allow-Headers',
                        'Authorization',
                        'X-Requested-With'
                    ],
                ]
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

}