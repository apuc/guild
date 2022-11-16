<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentField */

$this->title = 'Создать ноое поле';
$this->params['breadcrumbs'][] = ['label' => 'Document Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
