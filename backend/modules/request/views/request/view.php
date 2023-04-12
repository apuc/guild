<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\request\models\Request */
/* @var $searchDataProvider \yii\data\ArrayDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="request-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
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
            'created_at',
            'updated_at',
            [
                'attribute' => 'user_id',
                'value' => function (\common\models\Request $model) {
                    return $model->user->userCard->fio ?? 'Не задано';
                }
            ],
            'title',
            [
                'attribute' => 'position_id',
                'value' => function (\common\models\Request $model) {
                    return $model->position->name ?? 'Не задано';
                }
            ],
//            'skill_ids',
            [
                'attribute' => 'skill_ids',
                'value' => function (\common\models\Request $model) {
                    $skillStr = '';
                    foreach ($model->skills as $skill) {
                        $skillStr .= $skill['name'] . ", ";
                    }
                    return $skillStr;
                }
            ],
            [
                'attribute' => 'knowledge_level_id',
                'value' => function (\common\models\Request $model) {
                    return \common\models\UserCard::getLevelList()[$model->knowledge_level_id];
                }
            ],
            'descr:ntext',
            'specialist_count',
            [
                'attribute' => 'status',
                'value' => function (\common\models\Request $model) {
                    return \common\models\Request::getStatus()[$model->status] ?? 'Не задано';
                }
            ],
        ],
    ]) ?>

    <h3>Подходящие кандидаты</h3>

    <?= GridView::widget([
        'dataProvider' => $searchDataProvider,
        'columns' => [['class' => 'yii\grid\SerialColumn'],
            'id',
            'fio',
        ],
    ]); ?>


</div>
