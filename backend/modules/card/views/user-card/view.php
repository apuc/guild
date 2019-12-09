<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */
/* @var $userData common\models\User */
/* @var $skills \common\models\CardSkill */
/* @var $skill \common\models\Skill */
/* @var $modelFildValue yii\data\ActiveDataProvider */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Профили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-card-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'passport',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('img', null, ['src' => $model->photo, 'width' => '100px']);
                }
            ],
            [
                'attribute' => 'resume',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Скачать', $model->resume, ['target' => '_blank']);
                }
            ],
            [
                    'attribute' => 'city',
                    'value' => $model->city
            ],
            [
                'attribute' => 'gender',
                'value' => $model->gendersText,
            ],

            'email:email',

            'dob',
            [
                'attribute' => 'status',
                'value' => $model->status0->name,
            ],
            'salary',
            [
                'attribute' => 'position_id',
                'value' => (isset($model->position->name)) ? $model->position->name : 'Без должности',
            ],
            'created_at',
            'updated_at',
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
                    return $model->getValue();
                }
            ],
        ],
    ]); ?>

</div>