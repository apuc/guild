<?php

use common\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\ResumeTemplate */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Resume Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="resume-template-view">

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
            'title',
            'created_at',
            'updated_at',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' =>  StatusHelper::statusLabel($model->status),
            ],
            'header_text',
            [
                'attribute'=>'header_image',
                'value'=>$model->header_image,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
            [
                'attribute' => 'template_body',
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
