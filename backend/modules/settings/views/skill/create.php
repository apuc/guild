<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Skill */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Навыки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
