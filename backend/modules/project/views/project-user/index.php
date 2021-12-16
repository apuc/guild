<?php

use backend\modules\card\models\UserCard;
use backend\modules\project\models\Project;
use common\models\User;
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
                'filter' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value' => 'project.name'
            ],
            [
                'attribute' => 'user_id',
                'filter' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
                'value' => 'user.username'
            ],
            [
                'attribute' => 'card_id',
                'filter' => UserCard::find()->select(['fio', 'id'])->indexBy('id')->column(),
                'value' => 'card.fio'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
