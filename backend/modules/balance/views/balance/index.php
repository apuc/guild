<?php

use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

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
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'type',
                    'data' => \common\models\Balance::getTypeList(),
                    'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'summ',
                'filter'    => \backend\widgets\SummRangeWidget::widget([
                    'model' => $searchModel,
                ]),

            ],
            [
                'attribute' => 'dt_add',
                'value' => 'dt_add',
                'filter' => \yii\jui\DatePicker::widget(['language' => 'ru', 'dateFormat' => 'dd-MM-yyyy']),
                'format' => 'html',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
