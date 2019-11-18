<?php

namespace frontend\modules\card\models;

use common\models\CardSkill;
use yii\helpers\ArrayHelper;

class UserCard extends \common\models\UserCard
{
    public $fields;
    public $skill;

    public function init()
    {
        parent::init();

        $skill = ArrayHelper::getColumn(
            CardSkill::find()->where(['card_id' => \Yii::$app->request->get('id')])->all(),
            'skill_id'
        );

        if (!empty($skill)) {
            $this->skill = $skill;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('UserCard');

        if ($post['skill']) {
            CardSkill::deleteAll(['card_id' => $this->id]);

            foreach ($post['skill'] as $item) {
                $skill = new CardSkill();
                $skill->skill_id = $item;
                $skill->card_id = $this->id;

                $skill->save();
            }
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
