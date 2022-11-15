<?php

use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\card\models\ResumeTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны резюме';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-template-index">

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
            'updated_at',

            //'template_body:ntext',
            //'header_text',
            //'header_image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
