<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillCategory */

$this->title = 'Create Skill Category';
$this->params['breadcrumbs'][] = ['label' => 'Skill Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
