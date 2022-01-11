<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\AccompanyingDocument */

$this->title = 'Добавить сопроводительный документ';
$this->params['breadcrumbs'][] = ['label' => 'Accompanying Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accompanying-document-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
