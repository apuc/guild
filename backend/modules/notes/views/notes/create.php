<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\notes\models\Note */

$this->title = 'Создать заметку';
$this->params['breadcrumbs'][] = ['label' => 'Заметки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
