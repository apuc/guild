<?php

use app\modules\accesses\models\AccessesSearch;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\accesses\models\AccessesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доступы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesses-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить доступ', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сгруппированный вид', ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'login',
            'password',
            'link',
            'project',
            'info',
            ['class' => 'yii\grid\ActionColumn']
        ],
    ]);
    ?>
</div>
