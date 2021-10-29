<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Questionnaire */

$this->title = 'Создание анкеты';
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
