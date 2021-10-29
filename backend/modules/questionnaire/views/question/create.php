<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Question */

$this->title = 'Создание вопроса';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
