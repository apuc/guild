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
 * @property int $owner_id
 *
 * @property FieldsValue[] $fieldsValues
 * @property Company $company
 * @property User $owner
 * @property ProjectUser[] $projectUsers
 * @property Mark[] $mark
 * @property MarkEntity[] $markEntity
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
            [['name', 'owner_id', 'status'], 'required'],
            [['owner_id', 'name'], 'unique', 'targetAttribute' => ['owner_id', 'name']],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
            [['name'], 'string', 'max' => 255],
            [['budget'], 'string', 'max' => 100],
            [['owner_id'], 'integer'],
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
            'owner_id' => 'Владелец проекта',
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
    public function getColumns()
    {
        return $this->hasMany(ProjectColumn::class, ['project_id' => 'id'])
            ->with('tasks')
            ->where(['status' => ProjectColumn::STATUS_ACTIVE])->orderBy('priority');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasMany(Mark::class, ['id' => 'mark_id'])
            ->via('markEntity');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkEntity()
    {
        return $this->hasMany(MarkEntity::class, ['entity_id' => 'id'])
            ->where(['entity_type' => Entity::ENTITY_TYPE_PROJECT]);
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
