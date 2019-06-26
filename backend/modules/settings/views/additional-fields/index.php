<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\card\models\AdditionalFieldsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дополнительные поля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-fields-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'label' => 'Доп. информация',
                'format' => 'raw',
                'value' => function ($model) {
                    $dataProvider = new ActiveDataProvider([
                        'query' => $model->getUseFields(),
                    ]);
                    return ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_additional',
                        'layout' => "{items}",

                    ]);
                },
                'headerOptions' => ['width' => '300'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
