<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'User Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-card-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'passport',
            [
                'label' => 'Photo',
                'format' => 'raw',
                'value' => function($model){
                    return Html::tag('img', null, ['src' => $model->photo, 'width' => '100px']);
                }
            ],
            [
                'label' => 'Resume',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('Скачать', $model->resume, ['target' => '_blank']);
                }
            ],
            [
                'label' => 'gender',
                'value' => $model->gendersText,
            ],

            'email:email',

            'dob',
            [
                'label' => 'status',
                'value' => $model->status0->name,
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h2>Дополнительные сведения</h2>

    <?= GridView::widget([
        'dataProvider' => $modelFildValue,
        'layout'=>"{items}",
        'columns' => [
            'field.name:text:Поле',
            'value',
        ],
    ]); ?>


</div>
