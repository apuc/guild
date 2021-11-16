<?php

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
                'filter' => User::find()->select(['username', 'user.id'])
                    ->joinWith('manager')->where(['not',['manager.user_id' => null]])->indexBy('user.id')->column(),
                'value' => 'manager.user.username',
            ],
            [
                'attribute' => 'employee_id',
                'filter' => User::find()->select(['username', 'user.id'])
                    ->joinWith('manager')->where(['manager.user_id' => null])->indexBy('user.id')->column(),
                'value' => 'user.username',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
