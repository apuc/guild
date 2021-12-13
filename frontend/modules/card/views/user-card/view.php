<?php

use asmoday74\ckeditor5\EditorClassic;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $skills \common\models\CardSkill */
/* @var $skill \common\models\Skill */
/* @var $achievements \common\models\Achievement */
/* @var $modelFildValue yii\data\ActiveDataProvider */
/* @var $model */

$this->title = 'Профиль';
?>
<div class="user-card-view">
    <h3>Личная информация</h3>
    <?php
    echo Html::a('Изменить профиль', ['/card/user-card/update'], ['class' => 'btn btn-success'])
    . '&nbsp' . Html::a('Изменить пароль', ['/card/user-card/password'], ['class' => 'btn btn-success'])
    . '&nbsp' . Html::a('Изменить резюме', ['/card/user-card/resume'], ['class' => 'btn btn-success']). '<br><br>';

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

    <h2>Достижения</h2>
    <?php foreach ($achievements as $achievement) : ?>
        <div class="btn btn-default btn-sm">
            <?= Html::tag('img', null,
                ['src' =>  $achievement['achievement']->img, 'height' => '50px','width' => '50px']
            ) ?>
            <?= $achievement['achievement']->title; ?>
        </div>
    <?php endforeach; ?>
</div>
