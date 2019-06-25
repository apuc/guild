<?php


namespace backend\modules\balance\models;


use common\models\FieldsValue;
use common\models\FieldsValueNew;
use common\models\ProjectUser;
use yii\helpers\ArrayHelper;

class Balance extends \common\models\Balance
{
    public $fields;

    public function init()
    {
        parent::init();
        $fieldValue = FieldsValueNew::find()
            ->where(
                [
                    //'balance_id' => \Yii::$app->request->get('id'),
                    'item_id' => \Yii::$app->request->get('id'),
                    'item_type' => FieldsValueNew::TYPE_BALANCE,
                ])
            ->all();
        $array = [];
        if (!empty($fieldValue)) {
            foreach ($fieldValue as $item) {
                array_push($array, ['field_id' => $item->field_id, 'value' => $item->value, 'order' => $item->order]);
            }
            $this->fields = $array;
        } else {
            $this->fields = [
                [
                    'field_id' => null,
                    'value' => null,
                    'order' => null,
                ],
            ];
        }

//        $user = ArrayHelper::getColumn(ProjectUser::find()->where(['project_id' => \Yii::$app->request->get('id')])->all(),
//            'card_id');
//
//        if (!empty($user)) {
//            $this->user = $user;
//
//        }
    }
}