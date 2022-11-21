<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentTemplate */

$this->title = 'Создать шаблон документа';
$this->params['breadcrumbs'][] = ['label' => 'Document Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
