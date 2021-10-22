<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\QuestionnaireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список анкет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-index">

    <!--    <h1>-->
    <!--       <?//= Html::encode($this->title) ?>   -->
    <!--    </h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//           'id',

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
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return  $model->getCategoryTitle();
                }
            ],
//            'created_at',
//            'updated_at',
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return $model->limitTime;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
