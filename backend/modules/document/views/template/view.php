<?php

use backend\modules\document\models\DocumentField;
use backend\modules\document\models\Template;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $templateFieldDataProvider yii\data\ActiveDataProvider  */
/* @var $model backend\modules\document\models\Template */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="template-view">

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
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Поля шаблона:'?>
        </h2>
    </div>

    <?= GridView::widget([
        'dataProvider' => $templateFieldDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'field_id',
                'filter' => DocumentField::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'field.title',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
                'controller' => 'template-document-field',
                'buttons' => [
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'template-document-field/delete', 'id' => $model['id'], 'template_id' => $model['template_id']
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
            ['template-document-field/create', 'template_id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
