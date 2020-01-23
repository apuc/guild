<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Профили', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="user-card-update">

    <?php echo Html::a('Изменить пароль', ['password', 'id' => $model->id], ['class' => 'btn btn-success']);
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
