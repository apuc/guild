<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created_at',
            [
                'attribute' => 'today',
                'format' => 'raw',
                'label' => 'Задачи',
                'value' => function ($model) {
                    $text = '';
                    if ($model->task) {
                        $i = 1;
                        foreach ($model->task as $task) {
                            $text .= "<p>$i. ($task->hours_spent ч., $task->minutes_spent мин.) $task->task</p>";
                            $i++;
                        }
                    }
                    return $text;
                }
            ],
            [
                'format' => 'raw',
                'attribute' => 'Что было сделано сегодня?',
                'filter' => Html::activeTextInput($searchModel, 'today', ['class' => 'form-control']),
                'value' => function ($data) { return '<div class="custom-text">'.$data->today.'</div>'; },
            ],
            [
                'format' => 'raw',
                'attribute' => 'Какие сложности возникли?',
                'filter' => Html::activeTextInput($searchModel, 'difficulties', ['class' => 'form-control']),
                'value' => function ($data) { return '<div class="custom-text">'.$data->difficulties.'</div>'; },
            ],
            [
                'format' => 'raw',
                'attribute' => 'Что планируется сделать завтра?',
                'filter' => Html::activeTextInput($searchModel, 'tomorrow', ['class' => 'form-control']),
                'value' => function ($data) { return '<div class="custom-text">'.$data->tomorrow.'</div>'; },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
