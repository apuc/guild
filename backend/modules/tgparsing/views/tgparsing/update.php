<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\tgparsing\models\Tgparsing */

$this->title = 'Редактировать пост: ' . $model->post_id;
$this->params['breadcrumbs'][] = ['label' => 'Tgparsings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tgparsing-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
