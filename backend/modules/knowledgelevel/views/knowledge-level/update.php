<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\knowledgelevel\models\KnowledgeLevel */

$this->title = 'Редактировать: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Уровень знаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="knowledge-level-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
