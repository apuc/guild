<?php


namespace common\models;

use common\classes\Debug;
use PHPUnit\Framework\MockObject\Matcher\DeferredError;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property int $type
 * @property int $summ
 * @property int $dt_add
 */
class Balance extends \yii\db\ActiveRecord
{
    const TYPE_ACTIVE = 1;
    const TYPE_PASSIVE = 0;

    public $fields;

    public function init()
    {
        parent::init();
        $fieldValue = FieldsValueNew::find()
            ->where(
                [
                    'item_id' => \Yii::$app->request->get('id'),
//                    'item_id' => $this->id,
                    'item_type' => FieldsValueNew::TYPE_BALANCE,
                ])
            ->with('field')
            ->all();
        $array = [];
        if (!empty($fieldValue)) {
            foreach ($fieldValue as $item) {
                array_push($array,
                    ['field_id' => $item->field_id,
                        'value' => $item->value,
                        'order' => $item->order,
                        'type_file' => $item->type_file,
                        'field_name' => $item->field->name]);
            }
            $this->fields = $array;
        } else {
            $this->fields = [
                [
                    'field_id' => null,
                    'value' => null,
                    'order' => null,
                    'type_file' => null,
                    'field_name' => null,
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

    public static function getTypeName($id)
    {
        return self::getTypeList()[$id];
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_ACTIVE => 'Актив',
            self::TYPE_PASSIVE => 'Пассив',
        ];
    }

    public static function getNameList($type)
    {

        return ArrayHelper::map(
            AdditionalFields::find()
                ->leftJoin('use_field', 'additional_fields.id=use_field.field_id')
                ->where(['use_field.use' => $type])->all(), 'id', 'name'
        );
    }

    public static function tableName()
    {
        return 'balance';
    }

    public function rules()
    {
        return [
            [['type', 'summ', 'dt_add'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'type' => 'Тип',
            'summ' => 'Сумма',
            'dt_add' => 'Дата добавления',
            'value' => 'Значение',
        ];
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->dt_add = date('d-m-Y', $this->dt_add);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldsValues()
    {
        return $this->hasMany(FieldsValueNew::class, ['item_id' => 'id'])->where(['item_type' => FieldsValueNew::TYPE_BALANCE])->with('field');
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('Balance');

        FieldsValueNew::deleteAll(['item_id' => $this->id, 'item_type' => FieldsValueNew::TYPE_BALANCE]);

        foreach ($post['fields'] as $item) {
            $fieldsValue = new FieldsValueNew();
            $fieldsValue->field_id = $item['field_id'];
            $fieldsValue->value = $item['value'];
            $fieldsValue->order = $item['order'];
            $fieldsValue->item_id = $this->id;
            $fieldsValue->item_type = FieldsValueNew::TYPE_BALANCE;

            if(is_file(Yii::getAlias('@frontend') . '/web/' . $item['value'])){
                $fieldsValue->type_file = 'file';
            }else{
                $fieldsValue->type_file = 'text';
            }

            $fieldsValue->save();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}