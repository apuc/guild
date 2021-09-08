<?php


use common\models\Reports;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_id__fio */

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
.date_sort {
display: inline-flex;
}
.row * {
    margin-right: 10px;
}
');

define('TODAY', date('Y-m-d'));
define('WEEK_AGO', date('Y-m-d', time() - 3600 * 24 * 7));
function next_day($date, $number)
{
    return date('Y-m-d', strtotime($date) + 3600 * 24 * $number);
}
?>

<?= Html::beginTag('div', ['class' => 'reports-index'])?>
    <?=Html::beginTag('p')?>

        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сгрупированный по пользователям вид', ['group'], ['class' => 'btn btn-success']) ?>

    <?=Html::endTag('p')?>

    <?=Html::beginTag('p')?>

        <?php for ($date = TODAY; $date != WEEK_AGO; $date = next_day($date, -1)): ?>
            <?= Html::a($date, ['index', 'ReportsSearch[created_at]' => $date], ['class' => 'btn btn-primary']) ?>

        <?php endfor; ?>
    <?=Html::endTag('p')?>
<?= Html::endTag('div')?>

<?= Html::beginTag('div', ['class' => 'row'])?>
    <?= Html::beginTag('div', ['class' => 'col-xs-6'])?>
        <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['class' => 'date_sort'] ])?>

        <?php foreach (array_keys($searchModel->attributes )as $attribute): ?>
            <?php if($attribute == 'user_card_id'):?>
                <?php if($searchModel->user_card_id):?>
                    <?php foreach ($searchModel->user_card_id as $i => $id):?>
                        <?= $form->field($searchModel, 'user_card_id['.$i.']')->hiddenInput()->label(false)?>
                    <?php endforeach;?>
                <?php endif;?>
            <?php continue?>
            <?php endif;?>

            <?php if($attribute == 'created_at'):?>
                <?= Html::input('date', 'ReportsSearch[created_at]',
                    $searchModel->created_at ? $searchModel->created_at : date('Y-m-d'),
                    ['class' => 'form-control']) ?>

                <?= Html::submitButton('Сортировка по дате', ['class' => 'btn btn-danger']) ?>
                <?= Html::a('Все дни', ['index'], ['class' => 'btn btn-primary']) ?>
                <?php continue?>
            <?php endif?>

        <?php endforeach; ?>

        <?php ActiveForm::end() ?>
    <?= Html::endTag('div')?>
<?= Html::endTag('div')?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'format' => 'raw',
            'attribute' => 'created_at',
            'filter' => Html::input('date', 'ReportsSearch[created_at]', null, [
                    'class' => 'form-control',
                    'style' => 'display:',
                    'id' => 'date'

                ]),
            'value' => 'created_at',
        ],
//        [
//            'attribute' => 'today',
//            'format' => 'raw',
//            'value' => function ($model) {
//
//                $text = '';
//                if ($model->task) {
//                    $i = 1;
//                    foreach ($model->task as $task) {
//                        $text .= "<p>$i. ($task->hours_spent ч.) $task->task</p>";
//                        $i++;
//                    }
//                }
//                return $text;
//            }
//        ],
        //'difficulties',
        //'tomorrow',
        [
            'format' => 'raw',
            'attribute' => 'user_card_id',
            'filter' => kartik\select2\Select2::widget([
                'model' => $searchModel,
                'attribute' => 'user_card_id',
                'data' => $user_id__fio,
                'options' => ['multiple' => true, 'class' => 'form-control'],
            ]),
            'value' => function ($model) {
                return Html::a(Reports::getFio($model).' '.Html::tag('i', null, ['class' => 'far fa-calendar-alt']),
                    ['user', 'user_id' => $model['user_card_id']]);

            },
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]);?>
