<?php

use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-template-index">

    <p>
        <?= Html::a('Создать шаблон', ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter' => StatusHelper::statusList(),
                'value' => function($model){
                    return StatusHelper::statusLabel($model->status);
                }
            ],

            'created_at',
            //'updated_at',
//            'template_body:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
