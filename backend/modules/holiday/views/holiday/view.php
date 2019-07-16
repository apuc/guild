<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Отпуск №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список отпусков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="balance-view">
    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'ФИО',
            'value' => function($model)
            {
                return $model->users->fio;
            },
        ],
        'dt_start',
        'dt_end'
    ],
]) ?>