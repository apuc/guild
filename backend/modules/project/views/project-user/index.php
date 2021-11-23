<?php

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
