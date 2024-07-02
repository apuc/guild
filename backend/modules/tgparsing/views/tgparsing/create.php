<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\tgparsing\models\Tgparsing */

$this->title = 'Создать пост';
$this->params['breadcrumbs'][] = ['label' => 'Tgparsings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tgparsing-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
