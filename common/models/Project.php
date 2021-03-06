<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $budget
 * @property int $company_id
 * @property int $hh_id
 *
 * @property FieldsValue[] $fieldsValues
 * @property Company $company
 * @property ProjectUser[] $projectUsers
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
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
            [['name', 'status'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
            [['name'], 'string', 'max' => 255],
            [['budget'], 'string', 'max' => 100],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['hh_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hh::class, 'targetAttribute' => ['hh_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
            'status' => 'Статус',
            'updated_at' => 'Дата редактирования',
            'budget' => 'Бюджет',
            'company_id' => 'Компания',
            'hh_id' => 'Проект на hh.ru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldsValues()
    {
        return $this->hasMany(FieldsValueNew::class, ['item_id' => 'id'])->where(['item_type' => FieldsValueNew::TYPE_PROJECT])->with('field');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHh()
    {
        return $this->hasOne(Hh::class, ['id' => 'hh_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    public static function getListName()
    {
        return ArrayHelper::map(self::find()->all(), 'name', 'name');
    }

    public function getUsersNameList()
    {
        $model = $this->getProjectUsers()->with('card')->all();
        return ArrayHelper::getColumn($model, 'card.fio');
    }

    public function getStatus0()
    {
        return $this->hasOne(Status::class, ['id' => 'status']);
    }
}
