<?php

namespace console\controllers;

use common\models\FieldsValueNew;
use yii\console\Controller;

class MovingController extends Controller
{
    /*const TYPE_PROFILE = 0;
    const TYPE_PROJECT = 1;
    const TYPE_COMPANY = 2;
    const TYPE_BALANCE = 3;*/
    public function actionIndex()
    {
        $field_value = \common\models\FieldsValue::find()->all();

        foreach ($field_value as $item)
        {
            $new_value = new FieldsValueNew();
            $new_value->order = $item->order;
            $new_value->field_id = $item->field_id;
            $new_value->value = $item->value;

            if($item->card_id != null)
            {
                $new_value->item_type = 0;
                $new_value->item_id = $item->card_id;
            }
            if($item->balance_id != null)
            {
                $new_value->item_type = 3 ;
                $new_value->item_id = $item->balance_id;
            }
            if($item->project_id != null)
            {
                $new_value->item_type = 1;
                $new_value->item_id = $item->project_id;
            }
            if($item->company_id!= null)
            {
                $new_value->item_type = 2;
                $new_value->item_id = $item->company_id;
            }

            $new_value->save();
        }
    }
}