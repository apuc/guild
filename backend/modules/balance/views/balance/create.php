<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\Balance */

$this->title = 'Добавить баланс';
$this->params['breadcrumbs'][] = ['label' => 'Список балансов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
