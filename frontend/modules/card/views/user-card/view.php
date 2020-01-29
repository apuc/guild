<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $skills \common\models\CardSkill */
/* @var $skill \common\models\Skill */
/* @var $modelFildValue yii\data\ActiveDataProvider */

$this->title = 'Профиль';
?>
<div class="user-card-view">
    <h3>Личная информация</h3>
    <?php
    echo Html::a('Изменить профиль', ['/card/user-card/update', 'id' => $model->id], ['class' => 'btn btn-success'])
    . '&nbsp' . Html::a('Изменить пароль', ['/card/user-card/password', 'id' => $model->id], ['class' => 'btn btn-success']);
    echo  DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'ФИО', 'attribute' => 'fio',],
            ['label' => 'Email', 'attribute' => 'email',],
            ['label' => 'Дата рождения', 'attribute' => 'dob',],
            [
                'attribute' => 'position_id',
                'value' => (isset($model->position->name)) ? $model->position->name : 'Без должности',
            ],
        ],
    ]);
    ?>

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
