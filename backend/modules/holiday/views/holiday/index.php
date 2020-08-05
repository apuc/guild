<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список отпусков';
$this->params['breadcrumps'][] = $this->title;
?>
<div class="holiday-index">
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Календарь', ['calendar'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                [
                        'label' => 'ФИО',
                        'value' => function($model)
                        {
                            return $model->users->fio;
                        },
                        'filter' => \kartik\select2\Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'card_id',
                            'data' => \common\models\UserCard::getUserList(),
                            'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                             ]),
                ],
            [
                'attribute' => 'dt_start',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dt_start',
                    'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => [
                        'autocomplete' => 'off',
                    ],
                ]),
            ],
            [
                'attribute' => 'dt_end',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dt_end',
                    'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => [
                        'autocomplete' => 'off',
                    ],
                ]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);?>
</div>
