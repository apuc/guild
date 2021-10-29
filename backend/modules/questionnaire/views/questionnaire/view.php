<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Questionnaire */
/* @var $questionDataProvider yii\data\ActiveDataProvider */
/* @var $questionSearchModel  backend\modules\questionnaire\models\QuestionSearch */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="questionnaire-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return  $model->getCategoryTitle();
                }
            ],
            'title',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\helpers\StatusHelper::statusLabel($model->status);
                },
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return \common\helpers\TimeHelper::limitTime($model->time_limit);
                }
            ]
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Вопросы анкеты: '?>
        </h2>
    </div>

    <?php

    echo GridView::widget([
        'dataProvider' => $questionDataProvider,
        'filterModel' => $questionSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question_type_id',
            'question_body',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => \common\helpers\StatusHelper::statusList(),
                'value' => function($model) {
                    return \common\helpers\StatusHelper::statusLabel($model->status);
                },
            ],
            [
                'attribute' => 'time_limit',
                'format' => 'raw',
                'value' => function($model){
                    return \common\helpers\TimeHelper::limitTime($model->time_limit);
                }
            ],
            'score',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}', // {delete}
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['question/view', 'id' => $model['id']]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['question/update', 'id' => $model['id']]);
                    },
                ],
            ],
        ],

    ]);
    ?>

</div>
