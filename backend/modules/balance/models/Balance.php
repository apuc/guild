<?php


namespace backend\modules\balance\models;


use common\models\FieldsValue;
use common\models\ProjectUser;
use yii\helpers\ArrayHelper;

class Balance extends \common\models\Balance
{
    public function init()
    {
        parent::init();
        $fieldValue = FieldsValue::find()
            ->where(
                [
                    'balance_id' => \Yii::$app->request->get('id'),
                    'card_id' => null,
                    'company_id' => null,
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

        $user = ArrayHelper::getColumn(ProjectUser::find()->where(['project_id' => \Yii::$app->request->get('id')])->all(),
            'card_id');

        if (!empty($user)) {
            $this->user = $user;

        }
    }
}