<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\ResumeTemplate */

$this->title = 'Создать шаблон резюме';
$this->params['breadcrumbs'][] = ['label' => 'Resume Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
