<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\knowledgelevel\models\KnowledgeLevel */

$this->title = 'Добавить уровень знаний';
$this->params['breadcrumbs'][] = ['label' => 'Уровень знаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-level-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
