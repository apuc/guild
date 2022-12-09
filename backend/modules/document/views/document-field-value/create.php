<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentFieldValue */

$this->title = 'Create Document Field Value';
$this->params['breadcrumbs'][] = ['label' => 'Document Field Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
