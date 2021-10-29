<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Questionnaire */

$this->title = 'Изменение: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
