<?php


use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_id__fio */

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
        <?php
        if (!$_GET){
            $url = '../..'.Yii::$app->request->url .'?ReportsSearch[created_at]=';
        } else{
            $url = '../..'.Yii::$app->request->url .'&ReportsSearch[created_at]=';
        }

        for ($date = TODAY;
        $date != WEEK_AGO;
        $date = next_day($date, -1)): ?>

        <?= Html::a($date, [$url. $date], ['class' => 'btn btn-primary']) ?>
    <?php endfor; ?></div>
<div class="row">
    <div class="col-xs-6">

        <form method="get" style="display: inline-flex;">
            <?php if(isset($_GET['ReportsSearch'])):?>
            <input name="ReportsSearch[today]" type="hidden" value="<?=($_GET['ReportsSearch']['today'])?>">
            <input name="ReportsSearch[difficulties]" type="hidden" value="<?=($_GET['ReportsSearch']['difficulties'])?>">
            <input name="ReportsSearch[tomorrow]" type="hidden" value="<?=($_GET['ReportsSearch']['tomorrow'])?>">
            <input name="ReportsSearch[user_card_id]" type="hidden">
            <?php if(isset($_GET['ReportsSearch']['user_card_id'])){
                foreach ($_GET['ReportsSearch']['user_card_id'] as $res)
                echo
                 '<input name="ReportsSearch[user_card_id][]" type="hidden" value="'.$res.'">';
            }
            ?>
            <?php endif;
            ?>

            <?= Html::input('date', 'ReportsSearch[created_at]',
                isset($_GET['ReportsSearch']['created_at']) ? $_GET['ReportsSearch']['created_at'] : date('Y-m-d'), [
                    'class' => 'form-control',
                    'style' => 'display:',
                    'id' => 'date'

                ]) ?>




            <?= Html::button('Сортировка по дате', ['class' => 'btn btn-danger sort_by_date', 'type' => 'submit']) ?>

            <?= Html::a('Все дни', ['index'], ['class' => 'btn btn-dark']) ?>


        </form>
    </div>

</div>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'format' => 'raw',
            'attribute' => 'created_at',
            'filter' =>   Html::input('date', 'ReportsSearch[created_at]',
                null, [
                    'class' => 'form-control',
                    'style' => 'display:',
                    'id' => 'date'

                ]) ,
            'value' => 'created_at',
        ],
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
            'attribute' => 'user_card_id',
            'filter' => kartik\select2\Select2::widget([
                'model' => $searchModel,
                'attribute' => 'user_card_id',
                'data' => $user_id__fio,
                'options' => ['multiple' => true, 'class' => 'form-control'],
                'pluginOptions' => [

                    'multiple' => true,
                ],
            ]),
            'value' => function ($data) {
                return '<a href="'.Yii::getAlias('@web').'/reports/reports/user?id=' . $data['user_card_id'] . '">' . \common\models\Reports::getFio($data) . '</a>';
            },
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
$this->registerCssFile('../../css/site.css');
?>


</div>

<style>
    .row * {
        margin-right: 10px;
    }

</style>