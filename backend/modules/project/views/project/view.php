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
            [
                'label' => 'Сраница на hh.ru',
                'attribute' => 'hh.url'
            ],
            [
                'attribute' => 'owner_id',
                'value' => function (\common\models\Project $model) {
                    return $model->owner->userCard->fio ?? 'Не задано ФИО';
                }
            ],
            'description:ntext',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <h2>Дополнительные сведения</h2>

    <?= GridView::widget([
        'dataProvider' => $modelFildValue,
        'layout' => "{items}",
        'columns' => [
            'field.name:text:Поле',
            [
                'attribute' => 'value',
                'format' => 'raw',
                'label' => 'Значение',
                'value' => function ($model) {
                    return $model->getValue();
                }
            ],
        ],
    ]); ?>

    <h2>Пользователи проекта</h2>

    <?= GridView::widget([
        'dataProvider' => $modelUser,
        'layout' => "{items}",
        'columns' => [
            'card.fio:text:ФИО',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['/card/user-card/update', 'id' => $model->id],
                            ['target' => '_blank']
                        );
                    },
                    'view' => function ($url, $model) {
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

    <?php if ($jobsProvider): ?>
        <h2>Вакансии hh.ru</h2>
        <?= GridView::widget([
            'dataProvider' => $jobsProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'title',
                'url:url',
                'salary_from',
                'salary_to',
                'salary_currency',
                'address',
                'dt_add:date',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}'
                ],
            ],
        ]); ?>
    <?php endif; ?>

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
