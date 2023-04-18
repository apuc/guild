<?php

namespace common\models;

use common\classes\Debug;
use common\services\RequestService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $user_id
 * @property string $title
 * @property int $position_id
 * @property string $skill_ids
 * @property int $knowledge_level_id
 * @property string $descr
 * @property int $specialist_count
 * @property int $status
 * @property int $result_count
 * @property array $result_profiles
 */
class Request extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;

    public int $result_count = 0;

    public array $result_profiles = [];

    public array $skills = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'skills'], 'safe'],
            [['user_id', 'title', 'position_id', 'status'], 'required'],
            [['user_id', 'position_id', 'knowledge_level_id', 'specialist_count', 'status'], 'integer'],
            [['descr'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['skill_ids'], 'safe']
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $additionalFields = [
            'position',
            'skills',
            'result_count',
            'result_profiles',
            'level' => function (Request $model) {
                return UserCard::getLevelList()[$model->knowledge_level_id];
            },
        ];

        return array_merge($fields, $additionalFields);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'user_id' => 'Пользователь',
            'title' => 'Заголовок',
            'position_id' => 'Специализация',
            'skill_ids' => 'Навыки',
            'knowledge_level_id' => 'Уровень',
            'descr' => 'Описание',
            'specialist_count' => 'Кол-во специалистов',
            'status' => 'Статус',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->skill_ids && is_array($this->skill_ids)) {
                $this->skill_ids = implode(",", $this->skill_ids);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->skill_ids != "") {
            $this->skill_ids = explode(",", $this->skill_ids);
        }
        else {
            $this->skill_ids = [];
        }

        $this->skills = Skill::find()->where(['id' => $this->skill_ids])->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return string[]
     */
    public static function getStatus(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DISABLE => 'Выключен'
        ];
    }

}
