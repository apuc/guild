<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $fio */
/* @var $USER_ID */

$this->registerJs('let userID = '. $USER_ID);
$this->registerJs(file_get_contents(Url::base(true).'/js/calendar.js'));
$this->registerCssFile('@web/css/calendar.css');
$this->title = 'Календарь пользователя - ' . $fio;
?>
<?=Html::beginTag('section', ['class' => 'calendar-contain'])?>
    <?=Html::beginTag('aside', ['class' => 'calendar__sidebar'])?>
        <?=Html::beginTag('section', ['class' => 'title-bar'])?>
            <?= Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад', Yii::$app->request->referrer, ['class' => 'btn btn-primary',]) ?>
            <?= Html::input('date', null, date('Y-m-d'), ['class' => 'form-control', 'id' => 'date',]) ?>
        <?=Html::endTag('section')?>

        <?=Html::tag('h2', date('l').'<br>'.date('F d'), ['class' => 'sidebar__heading'])?>

        <?=Html::beginTag('ul', ['class' => 'sidebar__list'])?>
        <?=Html::endTag('ul')?>
    <?=Html::endTag('aside')?>

    <?=Html::beginTag('section', ['class' => 'calendar__days'])?>
    <?=Html::endTag('section')?>
<?=Html::endTag('section')?>



