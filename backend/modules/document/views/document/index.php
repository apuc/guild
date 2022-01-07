<?php

use backend\modules\document\models\Document;
use backend\modules\document\models\Template;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <p>
        <?= Html::a('Создать документ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'title',
                    'data' => Document::find()
                        ->select(['title', 'id'])->indexBy('id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '150px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ]),
                'value' => 'title',
            ],
            [
                'attribute' => 'template_id',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'template_id',
                    'data' => Template::find()->select(['title', 'id'])->indexBy('id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '150px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ]),
                'value' => 'template.title'
            ],
            [
                'attribute' => 'manager_id',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'manager_id',
                    'data' => Document::find()
                        ->joinWith(['manager', 'manager.userCard'])
                        ->select(['user_card.fio', 'manager.id'])->indexBy('id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '150px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ]),
                'value' => 'manager.userCard.fio',
            ],
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
