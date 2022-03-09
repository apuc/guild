<?php

use backend\modules\test\models\TestTask;
use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\test\models\TestTask */

$this->title = cut_title($model->description);
$this->params['breadcrumbs'][] = ['label' => 'Test Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

function cut_title($str)
{
    if(strlen($str) > 35){
        return mb_substr($str, 0, 35, 'UTF-8') . '...';
    }
    return $str;
}
?>
<div class="test-task-view">

    <p>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'description',
            [
                'attribute' => 'link',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->link), Url::to($model->link));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'level',
                'format' => 'raw',
                'filter' => TestTask::getLevelList(),
                'value' => function($model){
                    return TestTask::getLevelLabel($model->level);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function($model){
                    return StatusHelper::statusLabel($model->status);
                }
            ],
        ],
    ]) ?>

</div>
