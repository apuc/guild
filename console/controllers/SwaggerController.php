<?php

namespace console\controllers;

use OpenApi\Annotations\OpenApi;
use yii\console\Controller;
use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;


class SwaggerController extends Controller
{

    public function actionGo()
    {
        $openApi = \OpenApi\Generator::scan([Yii::getAlias("@frontend/modules/api")]);
        $file = Yii::getAlias('@frontend/web/api-doc/dist/swagger.yaml');
        $handle = fopen($file, 'wb');
        fwrite($handle, $openApi->toYaml());
        fclose($handle);
        echo $this->ansiFormat('Created \n", Console::FG_BLUE');
        return ExitCode::OK;
    }

}