<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectColumn */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Колонки проектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-column-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
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
            [
                'attribute' => 'project_id',
                'value' => ArrayHelper::getValue($model, 'project.name' ),
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'status',
                'value' => function (\common\models\ProjectColumn $model) {
                    return \common\models\ProjectColumn::getStatus()[$model->status] ?? 'Не задано';
                }
            ],
        ],
    ]) ?>

</div>
