<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_card".
 *
 * @property int $id
 * @property int $id_user
 * @property string $fio
 * @property string $passport
 * @property string $photo
 * @property string $email
 * @property int $gender
 * @property string $dob
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $resume
 * @property string $salary
 * @property int $position_id
 * @property int $city
 *
 * @property FieldsValue[] $fieldsValues
 * @property ProjectUser[] $projectUsers
 * @property Position $position
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
            [['fio', 'status', 'gender', 'email'], 'required'],
            [['gender', 'status', 'position_id', 'id_user'], 'integer'],
            [['dob', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['fio', 'passport', 'photo', 'email', 'resume', 'city'], 'string', 'max' => 255],
            [['salary'], 'string', 'max' => 100],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::class, 'targetAttribute' => ['position_id' => 'id']],
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
            'id_user' => 'ID пользователя',
            'fio' => 'ФИО',
            'passport' => 'Паспорт',
            'photo' => 'Фото',
            'email' => 'Email',
            'gender' => 'Пол',
            'dob' => 'Дата рождения',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирование',
            'deleted_at' => 'Дата удаления',
            'resume' => 'Резюме',
            'salary' => 'Зарплата',
            'position_id' => 'Должность',
            'city' => 'Город',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldsValues()
    {
        return $this->hasMany(FieldsValueNew::class, ['item_id' => 'id'])->where(['item_type' => FieldsValueNew::TYPE_PROFILE])->with('field');
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
    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
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

    public function getSkillValues()
    {
        return $this->hasMany(CardSkill::class, ['card_id' => 'id'])->with('skill');
    }

    public static function getNameSkills()
    {
        return ArrayHelper::map(Skill::find()->all(), 'id', 'name');
    }

    public static function getUserList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'fio');
    }

    public static function generateUserForUserCard($card_id = null)
    {
        $userCardQuery = self::find();
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
}
