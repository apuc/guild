<?php

use backend\modules\card\models\UserCard;
use backend\modules\company\models\Company;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\company\models\CompanyManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Менеджеры компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-manager-index">

    <p>
        <?= Html::a('Добавить компании менеджера', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'company_id',
                'filter' => Company::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value' => 'company.name',
            ],
            [
                'attribute' => 'user_card_id',
                'filter' => ArrayHelper::map(UserCard::getCardByUserRole('company_manager'), 'id', 'fio'),
                'value' => 'userCard.fio',
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                'buttons' =>
                    [
//                        'delete' => function ($url, $model) {
//                            return Html::a('<span class="glyphicon glyphicon-wrench"></span>', Url::to(['/company/company-manager/dismiss', 'id' => $model->id]), [
//                                'title' => Yii::t('yii', 'Уволить менеджера из компании?')
//                            ]); },
                        'delete' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                [
                                    '/company/company-manager/dismiss', 'id' => $model->id,
                                ],
                                [
                                    'data' => ['confirm' => 'Вы уверены, что хотите удалить этого менеджера?', 'method' => 'post']
                                ]
                            );
                        },
                    ]
            ],
        ]
    ]); ?>
</div>
