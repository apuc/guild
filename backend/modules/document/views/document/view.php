<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */
/* @var $documentFieldValuesDataProvider yii\data\ActiveDataProvider */

$this->title = 'Документ: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-view">

    <p>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'created_at',
            'updated_at',
            [
                'attribute' => 'template_id',
                'value' => ArrayHelper::getValue($model,'template.title'),
            ],
            [
                'attribute' => 'manager_id',
                'value' => ArrayHelper::getValue($model,'manager.userCard.fio')
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a(
            'Скачать файл',
            ['document/create-document', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

    <div>
        <h2>
            <?= 'Поля документа:'?>
        </h2>
    </div>

    <?= GridView::widget([
        'dataProvider' => $documentFieldValuesDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'field_id',
                'value' => 'field.title'
            ],
            'attribute' => 'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'document-field-value',
                'buttons' => [

                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['document-field-value/update', 'id' => $model['id'], 'document_id' => $model['document_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'document-field-value/delete', 'id' => $model['id'], 'document_id' => $model['document_id']
                            ],
                            [
                                'data' => ['confirm' => 'Вы уверены, что хотите удалить этот вопрос?', 'method' => 'post']
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a(
            'Добавить поле',
            ['document-field-value/create', 'document_id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
