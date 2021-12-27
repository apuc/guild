<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поля документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-index">

    <p>
        <?= Html::a('Создать поле документа', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
