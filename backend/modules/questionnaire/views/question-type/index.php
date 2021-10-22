<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\QuestionTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы вопросов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-type-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый тип вопроса', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'question_type',
            'slug',
            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
</div>
