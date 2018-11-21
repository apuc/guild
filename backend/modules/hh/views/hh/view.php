<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\hh\models\Hh */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'hh.ru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//\common\classes\Debug::prn(\common\hhapi\core\service\HHService::run()->vacancy(28246746)->get());
//\common\classes\Debug::dd(\common\hhapi\core\service\HHService::run()->company($model->hh_id)->getJobs())
?>
<div class="hh-view">

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
            'title',
            'hh_id',
            'url:url',
            'dt_add:date',
            'photo:image',
        ],
    ]) ?>

</div>
