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
                'value' => 'manager.user.userCard.fio',
            ],
            [
                'attribute' => 'employee_id',
                'value' => 'employee.email',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
