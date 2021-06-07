<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сгрупированный по пользователям вид', ['group'], ['class' => 'btn btn-success']) ?>
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
                'value' => function ($model) {
                    $text = '';
                    if ($model->task) {
                        $i = 1;
                        foreach ($model->task as $task) {
                            $text .= "<p>$i. ($task->hours_spent ч.) $task->task</p>";
                            $i++;
                        }
                    }
                    return $text;
                }
            ],
            'difficulties',
            'tomorrow',
            [
                'format' => 'raw',
                'attribute' => 'ФИО',
                'filter' => Html::activeTextInput($searchModel, 'fio', ['class' => 'form-control']),
                'value' => function ($data) { return \common\models\Reports::getFio($data); },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
