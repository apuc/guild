<?php

use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\company\models\BalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список балансов';
$this->params['breadcrumps'][] = $this->title;
?>
<div class="balance-index">
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Показать за прошлый месяц', ['index', 'previous_month' => true], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Показать за текущий месяц', ['index', 'month' => true], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::label('Сумма активных балансов: ' . $summ_info['active_summ']); ?>
    </p>
    <p>
        <?= Html::label('Сумма пассивных балансов: ' . $summ_info['passive_summ']); ?>
    </p>
    <p>
        <?= Html::label('Разница: ' . $summ_info['difference']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return \common\models\Balance::getTypeName($model->type);
                },
                'filter' => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'type',
                    'data' => \common\models\Balance::getTypeList(),
                    'options' => ['placeholder' => 'Начните вводить...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'summ',
                'filter' => \backend\widgets\SummRangeWidget::widget([
                    'model' => $searchModel,
                ]),

            ],
            [
                'attribute' => 'dt_add',
                'value' => 'dt_add',
                'filter' => \backend\widgets\DateRangeWidget::widget([
//                        'language' => 'ru',
//                        'dateFormat' => 'dd-MM-yyyy'
                    'model' => $searchModel,
                ]),
                'format' => 'html',
            ],
            [
                'label' => 'Доп. информация',
                'format' => 'raw',
                'value' => function ($model) {
                    $dataProvider = new ActiveDataProvider([
                        'query' => $model->getFieldsValues(),
                    ]);
                    return ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_additional',
                        'layout' => "{items}",

                    ]);
                },
                'filter'    => \backend\widgets\AdditionalFieldsFilterWidget::widget(['model' => $searchModel]),
                'headerOptions' => ['width' => '300'],

            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
