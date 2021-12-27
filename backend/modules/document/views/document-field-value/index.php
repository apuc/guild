<?php


use backend\modules\document\models\Document;
use common\models\DocumentField;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentFieldValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Значение полей документа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-value-index">

    <p>
        <?= Html::a('Установить значение значение ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'field_id',
                'filter' => DocumentField::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'field.title'
            ],
            [
                'attribute' => 'document_id',
                'filter' => Document::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'document.title'
            ],
            'attribute' => 'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
