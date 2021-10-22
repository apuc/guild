<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionnaireCategory */

$this->title = 'Создание категории анкеты';
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-categories-create">

    <!--    <h1>-->
    <!--        <?//= Html::encode($this->title) ?>  -->
    <!--    </h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
