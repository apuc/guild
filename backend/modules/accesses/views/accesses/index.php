<?php

use app\modules\accesses\models\AccessesSearch;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\accesses\models\AccessesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доступы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesses-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить доступ', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Все доступы', ['all'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchAccesses = new AccessesSearch();
                    $providerAccesses = $searchAccesses->search(Yii::$app->request->queryParams);
                    $providerAccesses->query->andWhere(['user_card.id_user' => $model->id_user]);

                    return Yii::$app->controller->renderPartial('_expand-row-details', ['dataProvider' => $providerAccesses]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            'fio',
            'email'
        ],
    ]);
    ?>
</div>
