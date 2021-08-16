<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\interview\models\InterviewRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Запрос интервью';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interview-request-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'email:email',
            'phone',
            'profile.fio',
            'user.email',
            'comment:ntext',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('Y-m-d H:i', $model->created_at);
                }
            ],
            [
                'attribute' => 'new',
                'value' => function($model){
                    return $model->new ? 'Новое' : 'Просмотренно';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
