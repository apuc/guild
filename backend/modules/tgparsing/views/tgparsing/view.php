<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\tgparsing\models\Tgparsing */

$this->title = $model->post_id;
$this->params['breadcrumbs'][] = ['label' => 'Tgparsings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tgparsing-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
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
        ],
    ]) ?>

</div>
