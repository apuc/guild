<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\ManagerEmployee */

$manager = ArrayHelper::getValue($model,'manager.user.username');
$employee = ArrayHelper::getValue($model,'user.username');

$this->title = 'Менеджер: ' . $manager . ', ' . 'сотрудник: ' . $employee;
$this->params['breadcrumbs'][] = ['label' => 'Manager Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="manager-employee-view">

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
                'attribute' => 'manager_id',
                'value' => ArrayHelper::getValue($model,'manager.user.username'),
            ],
            [
                'attribute' => 'employee_id',
                'value' => ArrayHelper::getValue($model,'user.username'),
            ],
        ],
    ]) ?>

</div>
