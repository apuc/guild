<?php

use backend\modules\document\models\DocumentField;
use backend\modules\document\models\Template;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\TemplateDocumentFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поля шаблона документа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-document-field-index">

    <p>
        <?= Html::a('Добавить поле в шаблон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'template_id',
                'filter' => Template::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'template.title',
            ],
            [
                'attribute' => 'field_id',
                'filter' => DocumentField::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'field.title',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
