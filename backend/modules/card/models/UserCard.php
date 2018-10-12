<?php

namespace backend\modules\card\models;

use backend\modules\settings\models\Skill;
use common\models\CardSkill;
use common\models\FieldsValue;
use yii\helpers\ArrayHelper;

class UserCard extends \common\models\UserCard
{
    public $fields;
    public $skill;

    public function init()
    {
        parent::init();

        $fieldValue = FieldsValue::find()->where(
            [
                'card_id' => \Yii::$app->request->get('id'),
                'project_id' => null,
                'company_id' => null,
            ])
            ->all();
        $array = [];
        if(!empty($fieldValue)){
            foreach ($fieldValue as $item){
                array_push($array, ['field_id' => $item->field_id, 'value' => $item->value, 'order' => $item->order]);
            }
            $this->fields = $array;
        }
        else{
            $this->fields = [
                [
                    'field_id'   => null,
                    'value'  => null,
                    'order' => null,
                ],
            ];
        }

        $skill = ArrayHelper::getColumn(CardSkill::find()->where(['card_id' => \Yii::$app->request->get('id')])->all(),
            'skill_id');

        if (!empty($skill)) {
            $this->skill = $skill;

        }

    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('UserCard');

        FieldsValue::deleteAll(['card_id' => $this->id]);

        foreach ( $post['fields'] as $item) {
            $fildsValue = new FieldsValue();
            $fildsValue->field_id = $item['field_id'];
            $fildsValue->value = $item['value'];
            $fildsValue->order = $item['order'];
            $fildsValue->card_id = $this->id;

            $fildsValue->save();
        }

        CardSkill::deleteAll(['card_id' => $this->id]);

        foreach ( $post['skill'] as $item) {
            $skill = new CardSkill();
            $skill->skill_id = $item;
            $skill->card_id = $this->id;

            $skill->save();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}