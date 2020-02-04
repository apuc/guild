<?php

namespace backend\modules\card\models;

use Yii;
use backend\modules\settings\models\Skill;
use common\classes\Debug;
use common\models\CardSkill;
use common\models\User;
use common\models\FieldsValue;
use common\models\FieldsValueNew;
use yii\helpers\ArrayHelper;

class UserCard extends \common\models\UserCard
{
    public $fields;
    public $skill;

    public function init()
    {
        parent::init();

        $fieldValue = FieldsValueNew::find()->where(
            [
                'item_id' => \Yii::$app->request->get('id'),
                'item_type' => FieldsValueNew::TYPE_PROFILE,
            ]
        )
            ->all();
        $array = [];
        if (!empty($fieldValue)) {
            foreach ($fieldValue as $item) {
                array_push(
                    $array,
                    [
                        'field_id' => $item->field_id,
                        'value' => $item->value,
                        'order' => $item->order,
                        'type_file' => $item->type_file,
                        'field_name' => $item->field->name
                    ]
                );
            }
            $this->fields = $array;
        } else {
            $this->fields = [
                [
                    'field_id'   => null,
                    'value'  => null,
                    'order' => null,
                    'field_name' => null,
                    'type_file' => null,
                ],
            ];
        }

        $skill = ArrayHelper::getColumn(
            CardSkill::find()->where(['card_id' => \Yii::$app->request->get('id')])->all(),
            'skill_id'
        );

        if (!empty($skill)) {
            $this->skill = $skill;
        }
    }

    public function beforeSave($insert)
    {
        $this->salary = str_replace(' ', '', \Yii::$app->request->post('UserCard')['salary']);
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('UserCard');

        if ($post['fields']) {
            FieldsValueNew::deleteAll(['item_id' => $this->id, 'item_type' => FieldsValueNew::TYPE_PROFILE]);
            foreach ($post['fields'] as $item) {
                $item['value'] = urldecode($item['value']);

                $fieldsValue = new FieldsValueNew();
                $fieldsValue->field_id = $item['field_id'];
                $fieldsValue->value = $item['value'];
                $fieldsValue->order = $item['order'];
                $fieldsValue->item_id = $this->id;
                $fieldsValue->item_type = FieldsValueNew::TYPE_PROFILE;
                if(is_file(Yii::getAlias('@frontend') . '/web/' . $item['value'])){
                    $fieldsValue->type_file = 'file';
                }else{
                    $fieldsValue->type_file = 'text';
                }

                $fieldsValue->save();
            }
        }

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

    public static function generateUser($email, $status)
    {
        $user = new User();
        $auth_key = Yii::$app->security->generateRandomString();
        $password = Yii::$app->security->generateRandomString(12);
        $password_hash = Yii::$app->security->generatePasswordHash($password);

        $user->username = $email;
        $user->auth_key = $auth_key;
        $user->password_hash = $password_hash;
        $user->email = $email;
        if ($status == 1) $user->status = 10;

        $user->save();

        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('user');
        $auth->assign($authorRole, $user->id);

        $log = "Логин: " . $email . " Пароль: " . $password . " | ";
        file_put_contents("log.txt", $log, FILE_APPEND | LOCK_EX);

        return $user->id;
    }

    public static function genereateLinlkOnUser($user_card, $user_id)
    {
        $user_card->id_user = $user_id;
        $user_card->save();
    }

    public static function generateUserForUserCard($card_id = null)
    {
        $userCardQuery = UserCard::find();
        $card_id ? $userCardQuery->where(['id' => $card_id]) : $userCardQuery->where(['id_user' => NULL]);
        $user_card_array = $userCardQuery->all();
        $user_array = User::find()->all();

        foreach ($user_card_array as $user_card_value) {

            foreach ($user_array as $user_value)
                if ($user_card_value->email == $user_value->email) {
                    $user_id = $user_value->id;
                    break;
                } else $user_id = NULL;

            if ($user_id) {
                UserCard::genereateLinlkOnUser($user_card_value, $user_id);
            } else {
                $user_id = UserCard::generateUser($user_card_value->email, $user_card_value->status);
                UserCard::genereateLinlkOnUser($user_card_value, $user_id);
            }
        }

        if ($user_card_array) return "data generated successfully";
        else return "no data to generate";
    }

    public static function getParameter($params, $key)
    {
        try {
            return $params[$key];
        } catch (\Exception $e) {
            return '';
        }
    }
}
