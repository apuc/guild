<?php

namespace common\models;

/**
 * This is the model class for table "user_card_portfolio_projects".
 *
 * @property int $id
 * @property int $card_id
 * @property string $title
 * @property string $description
 * @property int $main_stack
 * @property string $additional_stack
 * @property string $link
 *
 * @property Skill $mainStack
 * @property UserCard $card
 */
class UserCardPortfolioProjects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_card_portfolio_projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_id', 'title', 'main_stack', 'link'], 'required'],
            [['card_id', 'main_stack'], 'integer'],
            [['title', 'description', 'additional_stack', 'link'], 'string', 'max' => 255],
            [['main_stack'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::className(), 'targetAttribute' => ['main_stack' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::className(), 'targetAttribute' => ['card_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'title' => 'Название',
            'description' => 'Описание',
            'main_stack' => 'Основная технология',
            'additional_stack' => 'Используемые технологии',
            'link' => 'Ссылка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainStack()
    {
        return $this->hasOne(Skill::className(), ['id' => 'main_stack']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'card_id']);
    }

    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'main_stack']);
    }
}
