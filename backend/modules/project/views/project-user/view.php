<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectUser */

$this->title = 'Сотрудник проекта: ' . $model->project->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="project-user-view">

    <p>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            [
                'attribute' => 'project_id',
                'value' => ArrayHelper::getValue($model, 'project.name' ),
            ],
            [
                'attribute' => 'user_id',
                'value' => ArrayHelper::getValue($model, 'user.username' ),
            ],
            [
                'attribute' => 'card_id',
                'value' => ArrayHelper::getValue($model, 'card.fio' ),
            ],
            [
                'attribute' => 'project_role_id',
                'value' => ArrayHelper::getValue($model, 'projectRole.title' ),
            ],
            [
                'attribute' => 'status',
                'value' => ArrayHelper::getValue($model->statusList(),$model->status ),
            ],
        ],
    ]) ?>

</div>
