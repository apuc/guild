<?php

use kartik\markdown\Markdown;
use kartik\markdown\MarkdownEditor;

/* @var $contents */

$this->title = 'Справка';
$this->params['breadcrumbs'][] = ['label' => 'Справка', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Справка';
?>
<div class="help-default-index">

    <?= Markdown::convert($contents);?>

</div>
