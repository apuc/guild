<?php

namespace backend\modules\notes\models;

use Yii;
use common\models\FieldsValueNew;

class Note extends \common\models\Note
{

    public $fields;

    public function init()
    {
        parent::init();

        $fieldValue = FieldsValueNew::find()
            ->where(
                [
                    'item_id' => \Yii::$app->request->get('id'),
                    'item_type' => FieldsValueNew::TYPE_NOTE,
                ])
            ->all();
        $array = [];
        if(!empty($fieldValue)){
            foreach ($fieldValue as $item){
                array_push($array,
                    ['field_id' => $item->field_id,
                        'value' => $item->value,
                        'order' => $item->order,
                        'field_name' => $item->field->name]);
            }
            $this->fields = $array;
        }
        else{
            $this->fields = [
                [
                    'field_id'   => null,
                    'value'  => null,
                    'order' => null,
                    'field_name' => null,
                ],
            ];
        }
    }

    public function behaviors()
    {
        return [
            'log' => [
                'class' => \common\behaviors\LogBehavior::class,
            ]
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('Note');

        FieldsValueNew::deleteAll(['item_id' => $this->id, 'item_type' => FieldsValueNew::TYPE_NOTE]);

        foreach ( $post['fields'] as $item) {
            $item['value'] = urldecode($item['value']);

            $fieldsValue = new FieldsValueNew();
            $fieldsValue->field_id = $item['field_id'];
            $fieldsValue->item_id = $this->id;
            $fieldsValue->item_type = FieldsValueNew::TYPE_NOTE;
            $fieldsValue->order = $item['order'];
            $fieldsValue->value = $item['value'];

            if(is_file(Yii::getAlias('@frontend') . '/web/' . $item['value'])){
                $fieldsValue->type_file = 'file';
            }else{
                $fieldsValue->type_file = 'text';
            }

            $fieldsValue->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }
}