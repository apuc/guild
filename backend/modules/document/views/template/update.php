<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Template */

$this->title = 'Изменить шаблон: ' . cut_title($model->title);
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

function cut_title($str)
{
    if(strlen($str) > 35){
        return mb_substr($str, 0, 25, 'UTF-8') . '...';
    }
    return $str;
}
?>
<div class="template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
