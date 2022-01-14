<?php

use backend\modules\document\models\Document;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\AccompanyingDocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сопроводительные бумги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accompanying-document-index">

    <p>
        <?= Html::a('Добавить сопроводительный документ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'document_id',
                'filter' => Document::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'document.title'
            ],
            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
