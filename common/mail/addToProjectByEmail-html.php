<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $project \common\models\Project */

?>
<p>Здравствуйте, <b><?= $user->username ?></b>,</p>

Вас добавили в проект <a href="https://itguild.info/tracker/project/<?= $project->id ?>"><?= $project->name ?></a> .