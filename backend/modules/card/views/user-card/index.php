<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\card\models\UserCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Профили';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-card-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'photo',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img(Url::to($model->photo),[
                        'style' => 'width:100px;'
                    ]);
                },
            ],
            'fio',
            'passport',
            'email:email',
            //'gender',
            //'dob',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
