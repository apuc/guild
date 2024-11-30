<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\tgbotmsg\models\TgBotMsgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'TG сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-bot-msg-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dialog_id',
//            'ig_dialog_id',
            'text:ntext',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\TgBotMsg::getStatus()[$model->status];
                }
            ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
