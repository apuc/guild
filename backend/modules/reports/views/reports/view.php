<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */

$this->title = $model->created_at;
$this->params['breadcrumbs'][] = ['label' => 'Отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reports-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверенны, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'created_at',
            [
                'attribute' => 'today',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '';
                    if ($model->task) {
                        $i = 1;
                        foreach ($model->task as $task) {
                            $text .= "<p>$i. ($task->hours_spent ч., $task->minutes_spent мин.) $task->task</p>";
                            $i++;
                        }
                    }
                    return $text;
                }
            ],
            'difficulties',
            'tomorrow',
//            'user_card_id',
            [
                'format' => 'raw',
                'attribute' => 'asdФИО',
                'value' => function ($data) {
                    return \common\models\Reports::getFio($data);
                },
            ],
        ],
    ]) ?>

</div>
