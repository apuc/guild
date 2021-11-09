<?php

use backend\modules\questionnaire\models\QuestionnaireCategory;
use common\helpers\StatusHelper;
use common\helpers\TimeHelper;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionnaireCategory */
/* @var $questionnaireDataProvider yii\data\ActiveDataProvider */
/* @var $questionnaireSearchModel backend\modules\questionnaire\models\QuestionnaireCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="questionnaire-categories-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
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
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' =>  StatusHelper::statusLabel($model->status),
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $questionnaireDataProvider,
        'filterModel' => $questionnaireSearchModel,
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
            [
                'attribute' => 'category_id',
                'filter' => QuestionnaireCategory::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'category.title'
            ],
            [
                'attribute' => 'time_limit',
                'format' => 'raw',
                'value' => function($model){
                    return TimeHelper::limitTime($model->time_limit);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'questionnaire',
                'buttons' => [

                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['questionnaire/update', 'id' => $model['id'], 'category_id' => $model['category_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'questionnaire/delete', 'id' => $model['id'], 'category_id' => $model['category_id']
                            ],
                            [
                                'data' => ['confirm' => 'Вы уверены, что хотите удалить эту анкету?', 'method' => 'post']
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a(
            'Создать новую анкету',
            ['questionnaire/create', 'category_id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
