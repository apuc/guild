<?php

namespace backend\modules\help\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `help` module
 */
class HelpController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $contents = file_get_contents(Yii::getAlias('@helpDocument') . "/help.md");

        return $this->render('index', [
            'contents' => $contents,
        ]);
    }
}
