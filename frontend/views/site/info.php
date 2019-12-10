<?php

use common\classes\Debug;
use yii\widgets\DetailView;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $model,
]);

// Debug::dd($model);

// echo DetailView::widget([
//     'model' => $model,
//     'attributes' => [
//         'email',
//     ],
// ]);
