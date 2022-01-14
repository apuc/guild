<?php

use common\helpers\TemplateDocumentTypeHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">

    <p>
        <?= Html::a('Создать шаблон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'created_at',
            'updated_at',
            [
                'attribute' => 'document_type',
//                'format' => 'raw',
                'filter' => TemplateDocumentTypeHelper::getDocumentTypeList(),
                'value' => function($model){
                    return TemplateDocumentTypeHelper::getDocumentType($model->document_type);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {delete}',
            ],

        ],
    ]); ?>
</div>
