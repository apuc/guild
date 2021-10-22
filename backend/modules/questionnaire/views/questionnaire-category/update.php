<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionnaireCategory */

$this->title = 'Редактировать категорию анкет: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-category-update">

    <!--    <h1>-->
    <!--        <?//= Html::encode($this->title) ?>  -->
    <!--    </h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
