<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;

define('TODAY', date('Y-m-d'));
define('WEEK_AGO', date('Y-m-d', time() - 3600 * 24 * 7));
function next_day($date, $number)
{
    return date('Y-m-d', strtotime($date) + 3600 * 24 * $number);
}

?>
<div class="reports-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сгрупированный по пользователям вид', ['group'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?php for ($date = TODAY; $date != WEEK_AGO; $date = next_day($date, -1)): ?>
                <?= Html::a($date, ['reports/?date=' . $date], ['class' => 'btn btn-primary']) ?>
        <?php endfor; ?></div>
<div class="row">
    <div class="col-xs-6">

        <form method="get" style="display: inline-flex;">

            <?= Html::input('date', 'date', isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'), [
                'class' => 'form-control',
                'style' => 'display:',
                'id' => 'date'

            ]) ?>

            <?= Html::button('Сортировка по дате', ['class' => 'btn btn-danger sort_by_date', 'type' => 'submit']) ?>

            <?= Html::a('Все дни', ['index'], ['class' => 'btn btn-dark']) ?>


        </form>
    </div>

</div>
<!--    <div class="row" style="margin: 10px 0px 0 5px">-->
</p>
<?php
//echo '<pre>';
//var_dump($dataProvider);
//echo '</pre>';?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'created_at',
        [
            'attribute' => 'today',
            'format' => 'raw',
            'value' => function ($model) {

                $text = '';
                if ($model->task) {
                    $i = 1;
                    foreach ($model->task as $task) {
                        $text .= "<p>$i. ($task->hours_spent ч.) $task->task</p>";
                        $i++;
                    }
                }
                return $text;
            }
        ],
        'difficulties',
        'tomorrow',
        [
            'format' => 'raw',
            'attribute' => 'ФИО',
            'filter' => Html::activeTextInput($searchModel, 'fio', ['class' => 'form-control']),
            'value' => function ($data) {
                return '<a href="./user?id='.$data['user_card_id'].'">' . \common\models\Reports::getFio($data) . '</a>';
            },
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
$this->registerCssFile('../../css/site.css');
?>


</div>

<script>
    // let date = document.querySelector('#date')
    //     date.onchange = function (){
    //     window.location.replace(`./?date=${date.value}`);
    // }
</script>
<style>
    .row * {
        margin-right: 10px;
    }

    .row {
        margin-left: 1px;
    }
</style>