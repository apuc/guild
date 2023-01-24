<?php

namespace frontend\modules\api\models;

use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Project extends \common\models\Project implements Linkable
{
    public function fields(): array
    {
        return [
            'id',
            'name',
            'budget',
            'status',
            'hh_id' => function() {
                return $this->hh;
            },
            'company' => function() {
                return $this->company;
            }
        ];
    }

    public function extraFields(): array
    {
        return [];
    }

    public function getLinks(): array
    {
        return [
            Link::REL_SELF => Url::to(['index', 'project_id' => $this->id], true),
        ];
    }

    public function getCompany(): ActiveQuery
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
