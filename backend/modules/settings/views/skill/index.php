<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\settings\models\SkillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Навыки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Категории', ['/settings/skill-category'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Навыки на главной', ['/settings/skill/skills-on-main-page'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->name : '-';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
