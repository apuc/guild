<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
