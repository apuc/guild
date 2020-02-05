<?php

use backend\modules\reports\models\ReportsSearch;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доступы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesses-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Общий вид', ['index'], ['class' => 'btn btn-success']) ?>
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
                    $searchReports = new ReportsSearch();
                    $providerReports = $searchReports->search(Yii::$app->request->queryParams);
                    $providerReports->query->andWhere(['user_card.id_user' => $model->id_user]);

                    return Yii::$app->controller->renderPartial('_expand-row-details', ['dataProvider' => $providerReports]);
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
