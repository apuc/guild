<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'name',
            'access',
            [
                'attribute' => 'userCard.fio',
                'format' => 'raw',
                'value' => function(\common\models\Accesses $model){
                    return $model->getUserCardName();
                },
            ],

            [
                'attribute' => 'projects.name',
                'format' => 'raw',
                'value' => function(\common\models\Accesses $model){
                    return $model->getProjectName();
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
