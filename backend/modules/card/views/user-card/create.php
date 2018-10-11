<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */

$this->title = 'Новый профиль';
$this->params['breadcrumbs'][] = ['label' => 'Профили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-card-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
