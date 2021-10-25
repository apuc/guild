<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\UserQuestionnaireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Анкеты пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-questionnaire-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Назначить анкету пользователю', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'questionnaire_id',
                'value' => function($model){
                    return  $model->getQuestionnaireTitle();
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model){
                    return $model->getUserName();
                }
            ],
//            'UUID',
            'score',
            [
                'attribute' => 'percent_correct_answers',
                'value' => function($model) {
                    $percent = $model->percent_correct_answers * 100;
                    return $percent . '%';
                }
            ],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
