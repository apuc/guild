<?php

use backend\modules\card\models\UserCard;
use common\models\ManagerEmployee;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\employee\models\ManagerEmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-employee-index">

    <p>
        <?= Html::a('Назначить менеджеру работника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'manager_id',
                'filter' => UserCard::find()->select(['fio', 'user_card.id'])
                    ->joinWith('manager')->where(['not',['manager.user_card_id' => null]])
                    ->indexBy('user_card.id')->column(),
                'value' => 'manager.userCard.fio',
            ],
            [
                'attribute' => 'user_card_id',
                'filter' => ManagerEmployee::find()->select(['fio', 'manager_employee.id'])
                    ->joinWith('userCard')
                    ->indexBy('manager_employee.id')->column(),
                'value' => 'userCard.fio',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
