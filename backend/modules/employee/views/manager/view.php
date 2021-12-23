<?php

use backend\modules\card\models\UserCard;
use common\models\User;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\Manager */
/* @var $managerEmployeeSearchModel backend\modules\employee\models\ManagerEmployeeSearch */
/* @var $managerEmployeeDataProvider yii\data\ActiveDataProvider */

$this->title =  'Менеджер: ' . ArrayHelper::getValue($model,'user.username');
$this->params['breadcrumbs'][] = ['label' => 'Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="manager-view">

    <p>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить менеджера?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => ArrayHelper::getValue($model,'userCard.fio'),
            ],
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $managerEmployeeDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_card_id',
                'filter' => UserCard::find()->select(['fio', 'id'])->indexBy('id')->column(),
                'value' => 'userCard.fio',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'manager-employee',
                'buttons' => [

                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['manager-employee/update', 'id' => $model['id'], 'manager_id' => $model['manager_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'manager-employee/delete', 'id' => $model['id'], 'manager_id' => $model['manager_id']
                            ],
                            [
                                'data' => ['confirm' => 'Вы уверены, что хотите удалить этого сотрудника?', 'method' => 'post']
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
