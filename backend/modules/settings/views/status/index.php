<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\status\models\StatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статусы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'label' => 'Доп. информация',
                'format' => 'raw',
                'value' => function ($model) {
                    $dataProvider = new ActiveDataProvider([
                        'query' => $model->getUseStatuses(),
                    ]);
                    return ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_additional',
                        'layout' => "{items}",

                    ]);
                },
                'headerOptions' => ['width' => '300'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
