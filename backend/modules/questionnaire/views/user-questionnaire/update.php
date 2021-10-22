<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserQuestionnaire */

/* @var $modelCategory backend\modules\questionnaire\models\QuestionnaireCategory */

$this->title = 'Изменить: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-questionnaire-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelCategory' => $modelCategory,
    ]) ?>

</div>
