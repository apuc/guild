<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProviderF \yii\data\ActiveDataProvider
/* @var $model backend\modules\balance\models\Balance */

$this->title = 'Баланс №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список балансов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-view">
    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            //'id',
            [
                'attribute' => 'type',
                'value' => function($model){
                    return \common\models\Balance::getTypeName($model->type);
                }
            ],
            'summ',
            'dt_add',
        ],
    ]) ?>

    <h2>Дополнительные сведения</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProviderF,
        'layout' => "{items}",
        'columns' => [
            'field.name:text:Поле',
            [
                'attribute' => 'value',
                'label' => 'Значение'
            ],
        ],
    ]); ?>

</div>
