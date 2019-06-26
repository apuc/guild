<?php

namespace backend\modules\company\models;

use common\models\FieldsValue;

class Company extends \common\models\Company
{
    public $fields;

    public function init()
    {
        parent::init();

        $fieldValue = FieldsValue::find()->where(
            [
                'company_id' => \Yii::$app->request->get('id'),
                'project_id' => null,
                'card_id' => null,
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
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('Company');

        FieldsValue::deleteAll(['company_id' => $this->id]);

        foreach ( $post['fields'] as $item) {
            $fildsValue = new FieldsValue();
            $fildsValue->field_id = $item['field_id'];
            $fildsValue->value = $item['value'];
            $fildsValue->order = $item['order'];
            $fildsValue->company_id = $this->id;

            $fildsValue->save();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}