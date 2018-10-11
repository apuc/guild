<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "user_card".
 *
 * @property int $id
 * @property string $fio
 * @property string $passport
 * @property string $photo
 * @property string $email
 * @property int $gender
 * @property string $dob
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $resume
 * @property string $salary
 *
 * @property array $genders
 * @property string $gendersText
 *
 * @property Status $status0
 */
class UserCard extends \yii\db\ActiveRecord
{
    const GENDER_M = 0;
    const GENDER_W = 1;

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
    public static function tableName()
    {
        return 'user_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'status'], 'required'],
            [['status'], 'integer'],
            [['gender'], 'in', 'range' => array_keys($this->genders)],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['fio', 'passport', 'photo', 'email', 'resume'], 'string', 'max' => 255],
            [['salary'], 'string', 'max' => 100],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'passport' => 'Паспорт',
            'photo' => 'Фото',
            'email' => 'Email',
            'gender' => 'Пол',
            'dob' => 'Дата рождения',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирование',
            'resume' => 'Резюме',
            'salary' => 'Зарплата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldsValues()
    {
        return $this->hasMany(FieldsValue::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Status::class, ['id' => 'status']);
    }

    public function getGenders()
    {
        return [
            self::GENDER_M => 'Мужчина',
            self::GENDER_W => 'Женщина'
        ];
    }

    /**
     * @return string status text label
     */
    public function getGendersText()
    {
        return $this->genders[$this->gender];
    }
}
