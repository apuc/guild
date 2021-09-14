<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\achievements\models\Achievement */

$this->title = 'Создать достижение';
$this->params['breadcrumbs'][] = ['label' => 'Достижения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
