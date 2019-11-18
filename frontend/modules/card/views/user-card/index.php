<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $skills \common\models\CardSkill */
/* @var $skill \common\models\Skill */
/* @var $modelFildValue yii\data\ActiveDataProvider */

?>
<div class="user-card-view">

    <h3>Личная информация</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'ФИО', 'attribute' => 'fio',],
            ['label' => 'Пасспорт', 'attribute' => 'passport',],
            ['label' => 'Email', 'attribute' => 'email',],
            [
                'attribute' => 'gender',
                'value' => $model->gendersText,
            ],
            ['label' => 'Дата рождения', 'attribute' => 'dob',],
            [
                'attribute' => 'status',
                'value' => $model->status0->name,
            ],
            ['label' => 'Зарплата', 'attribute' => 'salary',],
            [
                'attribute' => 'position_id',
                'value' => (isset($model->position->name)) ? $model->position->name : 'Без должности',
            ],
            [
                'attribute' => 'Фото',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('img', null, ['src' => $model->photo, 'width' => '100px']);
                }
            ],
            [
                'attribute' => 'Resume',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Скачать', $model->resume, ['target' => '_blank']);
                }
            ],
            ['label' => 'Добвлен', 'attribute' => 'created_at',],
            ['label' => 'Изменен', 'attribute' => 'updated_at',],
        ],
    ]) ?>

    <h2>Навыки</h2>

    <?php foreach ($skills as $skill) : ?>
        <span class="btn btn-default btn-sm"><?= $skill['skill']->name; ?></span>
    <?php endforeach; ?>
    <h2>Дополнительные сведения</h2>

    <?= GridView::widget([
        'dataProvider' => $modelFildValue,
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
