<?php

namespace backend\modules\card\models;

use common\models\AchievementUserCard;
use common\models\CardSkill;
use common\models\FieldsValueNew;
use common\models\UserCardPortfolioProjects;
use Yii;
use yii\helpers\ArrayHelper;

class UserCard extends \common\models\UserCard
{
    public $fields;
    public $skill;
    public $achievements;
    public $portfolioProjects;

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

        $achievements = ArrayHelper::getColumn(AchievementUserCard::find()
            ->where(['user_card_id' => \Yii::$app->request->get('id')])
            ->innerJoinWith(['achievement' => function($query) {
                $query->andWhere(['status' => \common\models\Achievement::STATUS_ACTIVE]);
            }])
            ->all(),
            'achievement_id'
        );

        if (!empty($achievements)) {
            $this->achievements = $achievements;
        }

        /** @var UserCardPortfolioProjects[] $portfolioProjects */
        $portfolioProjects = UserCardPortfolioProjects::find()
            ->where(['card_id' => \Yii::$app->request->get('id')])
            ->all();

        $array = [];
        if (!empty($portfolioProjects)) {
            foreach ($portfolioProjects as $item) {
                array_push(
                    $array,
                    [
                        'id' => $item->id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'main_stack' => $item->main_stack,
                        'additional_stack' => $item->additional_stack,
                        'link' => $item->link
                    ]
                );
            }
            $this->portfolioProjects = $array;
        } else {
            $this->portfolioProjects = [
                [
                    'id' => null,
                    'title' => null,
                    'description' => null,
                    'main_stack' => null,
                    'additional_stack' => null,
                    'link' => null
                ]
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

    public function beforeSave($insert)
    {
        if(isset(\Yii::$app->request->post('UserCard')['salary']))
        {
            $this->salary = str_replace(' ', '', \Yii::$app->request->post('UserCard')['salary']);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('UserCard');
        if($post) {
            if (isset($post['fields'])) {
                FieldsValueNew::deleteAll(['item_id' => $this->id, 'item_type' => FieldsValueNew::TYPE_PROFILE]);
                foreach ($post['fields'] as $item) {
                    $item['value'] = urldecode($item['value']);

                    $fieldsValue = new FieldsValueNew();
                    $fieldsValue->field_id = $item['field_id'];
                    $fieldsValue->value = $item['value'];
                    $fieldsValue->order = $item['order'];
                    $fieldsValue->item_id = $this->id;
                    $fieldsValue->item_type = FieldsValueNew::TYPE_PROFILE;
                    if (is_file(Yii::getAlias('@frontend') . '/web/' . $item['value'])) {
                        $fieldsValue->type_file = 'file';
                    } else {
                        $fieldsValue->type_file = 'text';
                    }

                    $fieldsValue->save();
                }
            }
            if (array_key_exists('fields', $post) && is_array($post['fields'])) {
                CardSkill::deleteAll(['card_id' => $this->id]);
                if (is_array($post['skill']))
                    foreach ($post['skill'] as $item) {
                        $skill = new CardSkill();
                        $skill->skill_id = $item;
                        $skill->card_id = $this->id;

                        $skill->save();
                    }
            }

            if(array_key_exists('portfolioProjects', $post) && is_array($post['portfolioProjects'])){
                UserCardPortfolioProjects::deleteAll(['card_id' => $this->id]);

                foreach ($post['portfolioProjects'] as $item) {
                    $portfolioProject = new UserCardPortfolioProjects();
                    $portfolioProject->card_id = $this->id;
                    $portfolioProject->title = $item['title'];
                    $portfolioProject->description = $item['description'];
                    $portfolioProject->main_stack = $item['main_stack'];
                    $portfolioProject->additional_stack = $item['additional_stack'];
                    $portfolioProject->link = $item['link'];

                    $portfolioProject->save();
                }
            }

            if(array_key_exists('achievements', $post) && is_array($post['achievements'])){
                AchievementUserCard::deleteAll(['user_card_id' => $this->id]);

                foreach ($post['achievements'] as $item) {
                    $achCard = new AchievementUserCard();
                    $achCard->user_card_id = $this->id;
                    $achCard->achievement_id = $item;

                    $achCard->save();
                }
            }

            parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        }
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
