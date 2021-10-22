<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionType */

$this->title = 'Изменить тип вопроса: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Question Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
