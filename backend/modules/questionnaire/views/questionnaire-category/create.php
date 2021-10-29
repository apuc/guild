<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionnaireCategory */

$this->title = 'Создание категории анкеты';
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="questionnaire-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
