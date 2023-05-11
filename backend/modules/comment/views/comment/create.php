<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\comment\models\Comment */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
