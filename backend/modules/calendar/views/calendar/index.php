<?php

/* @var $searchModel backend\modules\card\models\UserCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<div style="display: flex;align-items: flex-start;">
<p>
    <select id="options" class="btn btn-secondary dropdown-toggle">
        <option selected="selected" value="?month=00">Выберите месяц</option>
        <option value="?month=00">Показать все</option>
        <option value="?month=01">январь</option>
        <option value="?month=02">февраль</option>
        <option value="?month=03">март</option>
        <option value="?month=04">апрель</option>
        <option value="?month=05">май</option>
        <option value="?month=06">июнь</option>
        <option value="?month=07">июль</option>
        <option value="?month=08">август</option>
        <option value="?month=09">сентябрь</option>
        <option value="?month=10">октябрь</option>
        <option value="?month=11">ноябрь</option>
        <option value="?month=12">декабрь</option>
    </select>
</p>
<?=Html::a('Календарь дней рождений '.Html::tag('i', null, ['class' => 'far fa-calendar-alt']),
    ['alternative'], ['class' => 'btn btn-success', 'style' => 'margin-left: 10px'])?>
</div>
<?php
Pjax::begin(['id' => 'reload']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'fio',
        'dob',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
Pjax::end();
?>