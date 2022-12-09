<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */
/* @var $documentFieldValuesDataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-view">

    <p>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Скачать', ['download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'company_id',
                'value' => ArrayHelper::getValue($model, 'company.name'),
            ],
            [
                'attribute' => 'manager_id',
                'value' => ArrayHelper::getValue($model, 'manager.userCard.fio'),
            ],
            [
                'attribute' => 'contractor_company_id',
                'value' => ArrayHelper::getValue($model, 'contractorCompany.name'),
            ],
            [
                'attribute' => 'contractor_manager_id',
                'value' => ArrayHelper::getValue($model, 'contractorManager.userCard.fio'),
            ],
            [
                'attribute' => 'body',
                'format' => 'raw',
            ],

            'created_at',
            'updated_at',
        ],
    ]) ?>

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
                'attribute' => 'document_field_id',
                'value' => 'documentField.title'
            ],
            'attribute' => 'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',//'{view} {update} {delete}',
                'controller' => 'document-field-value',
                'buttons' => [

                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['document-field-value/update', 'id' => $model['id'], 'fromDocument' => true]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
