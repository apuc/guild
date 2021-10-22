<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserQuestionnaire */
/* @var $modelCategory backend\modules\questionnaire\models\QuestionnaireCategory */

$this->title = 'Назначение анкеты пользователю';
$this->params['breadcrumbs'][] = ['label' => 'User Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-questionnaire-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelCategory' => $modelCategory,
    ]) ?>

</div>
