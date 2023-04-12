<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\request\models\Request */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Запросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
