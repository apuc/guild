<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\tgbotmsg\models\TgBotMsg */

$this->title = 'Создать сообщение';
$this->params['breadcrumbs'][] = ['label' => 'Сообщения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-bot-msg-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
