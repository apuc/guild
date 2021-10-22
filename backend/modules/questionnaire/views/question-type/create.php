<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionType */

$this->title = 'Создание типа вопроса';
$this->params['breadcrumbs'][] = ['label' => 'Question Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
