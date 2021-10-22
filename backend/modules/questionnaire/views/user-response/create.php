<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserResponse */

$this->title = 'Создать ответ пользователя';
$this->params['breadcrumbs'][] = ['label' => 'User Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-response-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
