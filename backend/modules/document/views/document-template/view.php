<?php

use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentTemplate */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Document Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-template-view">

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
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => StatusHelper::statusLabel($model->status),
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'template_body',
                'format' => 'raw'
            ],
            [
                'attribute' => 'Переменные в шаблоне',
                'value' => function($model){
                    preg_match_all('/(\${\w+})/', $model->template_body,$out);
                    return implode(",", $out[0]);
                },
            ],
        ],
    ]) ?>

</div>
