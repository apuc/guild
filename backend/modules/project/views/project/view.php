<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

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
        'dataProvider' => $modelFildValue,
        'layout'=>"{items}",
        'columns' => [
            'field.name:text:Поле',
            'value',
        ],
    ]); ?>

    <h2>Пользователи проекта</h2>

    <?= GridView::widget([
        'dataProvider' => $modelUser,
        'layout'=>"{items}",
        'columns' => [
            'card.fio:text:ФИО',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['/card/user-card/update', 'id' => $model->id],
                            ['target' => '_blank']
                        );
                    },
                    'view' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['/card/user-card/view', 'id' => $model->id],
                            ['target' => '_blank']
                        );
                    },
                ],

            ],
        ],
    ]); ?>
</div>
