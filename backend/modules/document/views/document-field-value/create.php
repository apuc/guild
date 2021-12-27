<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentFieldValue */

$this->title = 'Заполнить значение поля документа';
$this->params['breadcrumbs'][] = ['label' => 'Document Field Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-value-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
