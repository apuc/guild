<?php
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\modules\balance\models\Balance */

$this->title = 'Редактировать баланс №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список балансов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="balance-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
