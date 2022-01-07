<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поля документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новое поле', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'field_template',
                'value' => function($model) {
                    return '${' . $model->field_template . '}';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
