<?php

use backend\modules\card\models\UserCard;
use backend\modules\project\models\Project;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники на проектах';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-user-index">

    <p>
        <?= Html::a('Назначить сотрудника на проект', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Установить значения поля "Сотрудник"', ['set-user-fields'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Установить значения поля "Карточка"', ['set-card-fields'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'project_id',
                    'data' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '250px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ])
            ],
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '250px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ])
            ],
            [
                'attribute' => 'card_id',
                'value' => 'card.fio',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'card_id',
                    'data' => UserCard::find()->select(['fio', 'id'])->indexBy('id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '250px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
