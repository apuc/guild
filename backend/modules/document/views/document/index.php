<?php

use backend\modules\company\models\Company;
use backend\modules\employee\models\Manager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <p>
        <?= Html::a('Создать документ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
//            'body:ntext',
            [
                'attribute' => 'company_id',
                'filter' => Company::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value' => 'company.name'
            ],
            [
                'attribute' => 'contractor_company_id',
                'filter' => Company::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value' => 'contractorCompany.name'
            ],
            [
                'attribute' => 'manager_id',
                'filter' => Manager::find()->select(['fio', 'manager.id'])
                    ->joinWith('userCard')->indexBy('manager.id')->column(),
                'value' => 'manager.userCard.fio'
            ],
            [
                'attribute' => 'contractor_manager_id',
                'filter' => Manager::find()->select(['fio', 'manager.id'])
                    ->joinWith('userCard')->indexBy('manager.id')->column(),
                'value' => 'manager.userCard.fio'
            ],
            //'title',
            //'body:ntext',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {download}',
                'buttons' => [
                    'download' => function($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-download-alt"></span>',
                                     ['document/download', 'id' => $model->id]
                                );
                    }
                ]
            ]
        ],
    ]); ?>
</div>
