<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\settings\models\MarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mark-index">

    <p>
        <?= Html::a('Создать метку', ['create'], ['class' => 'btn btn-success']) ?>
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
