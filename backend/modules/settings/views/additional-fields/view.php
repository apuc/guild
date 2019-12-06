<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\AdditionalFields */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные поля', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-fields-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить поле?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Создать', ['create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Показать все', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
