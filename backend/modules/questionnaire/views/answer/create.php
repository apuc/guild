<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Answer */

$this->title = 'Создание нового ответа';
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
