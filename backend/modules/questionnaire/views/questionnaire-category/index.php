<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\QuestionnaireCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории анкет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новую категорию анкет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
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
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
