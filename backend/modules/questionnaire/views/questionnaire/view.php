<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Questionnaire */
/* @var $questionDataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="questionnaire-view">

    <!--    <h1>-->
    <!--        <?//= Html::encode($this->title) ?>  -->
    <!--    </h1>-->

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
                    return \yii\helpers\Html::tag(
                        'span',
                        $model->status ? 'Active' : 'Not Active',
                        [
                            'class' => 'label label-' . ($model->status ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return $model->limitTime;
                }
            ]
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Вопросы анкеты: ' . Html::encode($this->title) ?>
        </h2>
    </div>

    <?php

    echo GridView::widget([
        'dataProvider' => $questionDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'question_type_id',
            'questionnaire_id',
            'question_body',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\Html::tag(
                        'span',
                        $model->status ? 'Active' : 'Not Active',
                        [
                            'class' => 'label label-' . ($model->status ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
//            'created_at',
//            'updated_at',
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return $model->limitTime;
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
