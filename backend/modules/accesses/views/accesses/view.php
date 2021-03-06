<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Accesses */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Доступы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="accesses-view">


    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'login',
            'password',
            'link',
            'project',
            'info',
//            [
//                'attribute' => 'userCard.fio',
//                'format' => 'raw',
//                'value' => function(\common\models\Accesses $model){
//                    return $model->getUserCardName();
//                },
//            ],
//            [
//                'attribute' => 'projects.name',
//                'format' => 'raw',
//                'value' => function(\common\models\Accesses $model){
//                    return $model->getProjectName();
//                },
//            ],
        ],
    ]) ?>

</div>
