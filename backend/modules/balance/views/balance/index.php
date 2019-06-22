<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\company\models\BalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список балансов';
$this->params['breadcrumps'][] = $this->title;
?>
<div class="balance-index">
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'type',
                'summ',
                'dt_add',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
