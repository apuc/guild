<?php

namespace backend\modules\notes\models;

use common\models\FieldsValueNew;

class Note extends \common\models\Note
{

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('Note');

        FieldsValueNew::deleteAll(['item_id' => $this->id, 'item_type' => FieldsValueNew::TYPE_NOTE]);

        foreach ( $post['fields'] as $item) {
            $fieldsValue = new FieldsValueNew();
            $fieldsValue->field_id = $item['field_id'];
            $fieldsValue->item_id = $this->id;
            $fieldsValue->item_type = FieldsValueNew::TYPE_NOTE;
            $fieldsValue->order = $item['order'];
            $fieldsValue->value = $item['value'];

            $fieldsValue->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }
}