<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */
/* @var $userData common\models\User */
/* @var $skills \common\models\CardSkill */
/* @var $achievements \common\models\AchievementUserCard */
/* @var $skill \common\models\Skill */
/* @var $achievement \common\models\Achievement */
/* @var $modelFieldValue yii\data\ActiveDataProvider */
/* @var $changeDataProvider yii\data\ActiveDataProvider */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Профили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-card-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Резюме', ['user-card/resume', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'passport',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('img', null, ['src' => $model->photo, 'width' => '100px']);
                }
            ],
            [
                'attribute' => 'level',
                'value' => function($model){
                    return \common\models\UserCard::getLevelLabel($model->level);
                }
            ],
            [
                'attribute' => 'specification',
                'value' => $model->specification
            ],
            [
                'attribute' => 'resume',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Скачать', $model->resume, ['target' => '_blank']);
                }
            ],
            [
                    'attribute' => 'city',
                    'value' => $model->city
            ],
            [
                'attribute' => 'gender',
                'value' => $model->gendersText,
            ],

            'email:email',

            'link_vk:url',

            'link_telegram:url',

            'dob',
            [
                'attribute' => 'status',
                'value' => $model->status0->name,
            ],
            [
                'attribute' => 'salary',
                'visible' => Yii::$app->user->can('confidential_information')
            ],
            [
                'attribute' => 'position_id',
                'value' => (isset($model->position->name)) ? $model->position->name : 'Без должности',
            ],
            'created_at',
            'updated_at',
            'vc_text_short',
            [
                'attribute' => 'vc_text',
                'format' => 'raw'
            ],
            [
                'attribute' => 'test_task_getting_date',
                'format' => ['datetime', 'php:d.m.Y']
            ],
            [
                'attribute' => 'test_task_complete_date',
                'format' => ['datetime', 'php:d.m.Y']
            ],
            [
                'attribute' => 'resume_text',
                'format' => 'raw'
            ],
        ],
    ]) ?>

    <h2>Навыки</h2>
    <?php foreach ($skills as $skill) : ?>
        <span class="btn btn-default btn-sm"><?= $skill['skill']->name; ?></span>
    <?php endforeach; ?>

    <h2>Достижения</h2>
    <?php foreach ($achievements as $achievement) : ?>
        <a target="_blank"
           href="<?php \yii\helpers\Url::to(['/achievements/achievements/view', 'id' => $achievement['achievement']->id]);?>"
           class="btn btn-default btn-sm">
            <?= Html::tag('img', null,
                ['src' =>  $achievement['achievement']->img, 'height' => '50px', 'width' => '50px']
            ) ?>
            <?= $achievement['achievement']->title; ?>
        </a>
    <?php endforeach; ?>

    <h2>Дополнительные сведения</h2>

    <?= GridView::widget([
        'dataProvider' => $modelFieldValue,
        'layout' => "{items}",
        'columns' => [
            'field.name:text:Поле',
            [
                'attribute' => 'value',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getValue();
                }
            ],
        ],
    ]); ?>

    <h2>История изменений</h2>

    <?= GridView::widget([
        'dataProvider' => $changeDataProvider,
        'columns' => [
            'label',
            'old_value',
            'new_value',
            'created_at',
            ],
    ]); ?>

</div>