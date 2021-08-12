<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

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

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'Фото',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(Url::to($model->photo), [
                        'style' => 'width:100px;'
                    ]);
                },
            ],
            'fio',
//            'city',
            //'passport',
            [
                'attribute' => 'salary',
                'visible' => Yii::$app->user->can('confidential_information')
            ],
            'email:email',
            //'gender',
            //'dob',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status0->name;
                },
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROFILE),
                    'options' => ['placeholder' => 'Начните вводить...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            //'created_at',
            //'updated_at',
            [
                'label' => 'Навыки',
                'format' => 'raw',
                'value' => function ($model) {
                    $str = '';
                    foreach ($model->skillValues as $item) {
                        $str .= $item->skill->name . ', ';
                    }
                    $str = substr($str, 0, -2);
                    return $str;
                },
                'filter' => kartik\select2\Select2::widget([
                    'attribute' => 'skills',
                    'model' => $searchModel,
                    'data' => \common\models\UserCard::getNameSkills(),
                    'options' => ['multiple' => true, 'placeholder' => 'Выбрать параметр', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    echo "<h3>Сумма зарплат: " . $searchModel->total . "</h3>";
    ?>
</div>