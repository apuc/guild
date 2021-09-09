<?php
/* @var $this yii\web\View */
/* @var $id */

$this->title = 'Ошибка. Не удалось найти пользователя с таким ID - '.$id;
if (!Yii::$app->request->referrer){
    echo \yii\helpers\Html::a('<i class="fas fa-long-arrow-alt-left"></i> Репорты', ['index'], ['class' => 'btn btn-primary',]);
} else{
    echo \yii\helpers\Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад', Yii::$app->request->referrer, ['class' => 'btn btn-primary',]);
}
