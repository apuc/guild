<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\tgparsing\models\TgparsingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tgparsings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tgparsing-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'channel_id',
            'channel_link',
            'channel_title',
            'post_id',
            'content:html',
            'created_at',
            'updated_at',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return \common\models\Tgparsing::getStatus()[$model->status];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
