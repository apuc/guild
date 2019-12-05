<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProviderF \yii\data\ActiveDataProvider
/* @var $model backend\modules\notes\models\Note */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заметки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-view">
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
            'id',
            'name',
            'description:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h2>Дополнительные сведения</h2>
    <?= GridView::widget([
        'dataProvider' => $additionalDataProvider,
        'layout' => "{items}",
        'columns' => [
            'field.name:text:Поле',
            [
                'attribute' => 'value',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->type_file == 'file') {
                        return $model->value . ' (' . Html::a('Скачать', $model->value, ['target' => '_blank', 'download' => 'download']) . ')';
                    }
                    return $model->value;
                }
            ],
        ],
    ]); ?>

</div>
