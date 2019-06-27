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

//        var_dump($field_value[1]->id);
        for($i=0;$i<count($field_value);++$i)
        {
            $send_value = new FieldsValueNew();
            $send_value->order = $field_value[$i]->order;
//            echo $send_value->order;
//            echo '<br>';
            $send_value->field_id = $field_value[$i]->field_id;
            $send_value->value = $field_value[$i]->value;
            if($field_value[$i]->card_id != null)
            {
                $send_value->item_type = 0;
                $send_value->item_id = $field_value[$i]->card_id;
            }
            if($field_value[$i]->balance_id != null)
            {
                $send_value->item_type = 3 ;
                $send_value->item_id = $field_value[$i]->balance_id;
            }
            if($field_value[$i]->project_id != null)
            {
                $send_value->item_type = 1;
                $send_value->item_id = $field_value[$i]->project_id;
            }
            if($field_value[$i]->company_id!= null)
            {
                $send_value->item_type = 2;
                $send_value->item_id = $field_value[$i]->company_id;
            }
            $send_value->save();

        }
    }
}