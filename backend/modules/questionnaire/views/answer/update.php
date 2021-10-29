<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Answer */

$this->title = $model->answer_body;
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="answer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
