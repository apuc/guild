<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\AdditionalFields */

$this->title = 'Добавление поля';
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные поля', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-fields-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
