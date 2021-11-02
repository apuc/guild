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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => \common\helpers\StatusHelper::statusList(),
                'value' => function($model){
                    return \common\helpers\StatusHelper::statusLabel($model->status);
                }
            ],
            [
                'attribute' => 'category_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\QuestionnaireCategory::find()->all(), 'id', 'title'),
                'value' => function($model){
                    return  $model->getCategoryTitle();
                }
            ],
            [
                'attribute' => 'time_limit',
                'format' => 'raw',
                'value' => function($model){
                    return \common\helpers\TimeHelper::limitTime($model->time_limit);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
