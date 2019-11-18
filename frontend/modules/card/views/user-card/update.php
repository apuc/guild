<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */

$this->title = "Редактировать профиль";
?>
<div class="user-card-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
