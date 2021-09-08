<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProviderF \yii\data\ActiveDataProvider */
/* @var $model backend\modules\achievements\models\Achievement */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Достижения', 'url' => ['index']];
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
            'title',
            'slug',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => \common\models\Achievement::getStatusLabel()[$model->status ?? 0],
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('img', null, ['src' => $model->img, 'width' => '100px']);
                }
            ],
        ],
    ]) ?>

    <h2>История изменений</h2>
    <?= GridView::widget([
        'dataProvider' => $changeDataProvider,
        'columns' => [
            'label',
            'old_value',
            'new_value',
            'created_at',
        ],
    ]); ?>

</div>
