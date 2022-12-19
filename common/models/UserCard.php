<?php

namespace common\models;

use common\classes\Debug;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
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
 * @property string $vc_text
 * @property string $vc_text_short
 * @property string $specification
 * @property int $years_of_exp
 * @property int $position_id
 * @property int $city
 * @property int $level
 * @property string $test_task_getting_date
 * @property string $test_task_complete_date
 * @property string $resume_text
 * @property int $resume_template_id
 * @property int $resume_tariff
 * @property int $at_project
 *
 * @property FieldsValue[] $fieldsValues
 * @property ProjectUser[] $projectUsers
 * @property ResumeTemplate $resumeTemplate
 * @property Position $position
 * @property Status $status0
 * @property Achievement[] $achievements
 */
class UserCard extends \yii\db\ActiveRecord
{
    const GENDER_M = 0;
    const GENDER_W = 1;

    const LEVEL_JUNIOR = 1;
    const LEVEL_MIDDLE = 2;
    const LEVEL_MIDDLE_PLUS = 3;
    const LEVEL_SENIOR = 4;

    const SCENARIO_GENERATE_RESUME_TEXT = 'generate_resume_text';
    const SCENARIO_UPDATE_RESUME_TEXT = 'update_resume_text';
    const SCENARIO_DOWNLOAD_RESUME = 'download_resume_text';

    const AT_PROJECT_BUSY = 1;
    const AT_PROJECT_FREE = 0;


    /**
     * @return string[]
     */
    public static function getLevelList(): array
    {
        return [
            self::LEVEL_JUNIOR => 'Junior',
            self::LEVEL_MIDDLE => 'Middle',
            self::LEVEL_MIDDLE_PLUS => 'Middle+',
            self::LEVEL_SENIOR => 'Senior',
        ];
    }

    /**
     * @param int $level
     * @return string
     */
    public static function getLevelLabel(int $level): string
    {
        return self::getLevelList()[$level];
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
            [['fio', 'status', 'gender', 'email', 'level', 'position_id'], 'required'],
            [['gender', 'status', 'position_id', 'id_user', 'level', 'years_of_exp', 'resume_tariff', 'at_project'], 'integer'],
            [['dob', 'created_at', 'updated_at', 'deleted_at', 'vc_text', 'vc_text_short', 'test_task_getting_date', 'test_task_complete_date'], 'safe'],
            ['email', 'unique', 'message'=>'Почтовый адрес уже используется'],
            [['fio', 'passport', 'photo', 'email', 'resume', 'city', 'link_vk', 'link_telegram', 'specification'], 'string', 'max' => 255],
            [['salary'], 'string', 'max' => 100],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::class, 'targetAttribute' => ['position_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
            ['resume_template_id', 'required', 'on' => self::SCENARIO_GENERATE_RESUME_TEXT],
            ['resume_template_id', 'integer', 'on' => self::SCENARIO_GENERATE_RESUME_TEXT],
            ['resume_text', 'required', 'on' => self::SCENARIO_UPDATE_RESUME_TEXT],
            ['resume_template_id', 'required', 'on' => self::SCENARIO_DOWNLOAD_RESUME],
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
            'link_vk' => 'VK',
            'link_telegram' => 'Telegram',
            'vc_text' => 'Резюме текст',
            'vc_text_short' => 'Резюме короткий текст',
            'level' => 'Уровень',
            'years_of_exp' => 'Лет опыта',
            'specification' => 'Спецификация',
            'test_task_getting_date' => 'Дата получения тестового',
            'test_task_complete_date' => 'Дата выполнения тестового',
            'resume_template_id' => 'Шаблон резюме',
            'resume_text' => 'Резюме сгенерированный текст',
            'resume_tariff' => 'Ставка для резюме',
            'at_project' => 'Занят на проекте'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFieldsValues()
    {
        return $this->hasMany(FieldsValueNew::class, ['item_id' => 'id'])->where(['item_type' => FieldsValueNew::TYPE_PROFILE])->with('field');
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['card_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Status::class, ['id' => 'status']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAchievements(): ActiveQuery
    {
        return $this->hasMany(AchievementUserCard::class, ['user_card_id' => 'id'])->with('achievement');
    }

    public function getGenders()
    {
        return [
            self::GENDER_M => 'Мужчина',
            self::GENDER_W => 'Женщина'
        ];
    }

    public static function getBusyness()
    {
        return [
            self::AT_PROJECT_BUSY => 'На проекте',
            self::AT_PROJECT_FREE => 'Не занят'
        ];
    }

    /**
     * @throws Exception
     */
    public function getBusynessForUser($key)
    {
        return ArrayHelper::getValue($this->getBusyness(), $key);
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

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public static function getUserList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'fio');
    }

    public function getManager()
    {
        return $this->hasOne(Manager::class, ['user_card_id' => 'id']);
    }

    public function getManagerEmployee()
    {
        return $this->hasMany(ManagerEmployee::class, ['user_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyManagers()
    {
        return $this->hasMany(CompanyManager::className(), ['user_card_id' => 'id']);
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

    public static function getUserIdByCardId ($card_id)
    {
        $userCard = self::findOne(['id' => $card_id]);
        if (empty($userCard)) {
            return null;
        }
        return $userCard['id_user'];
    }

    public static function getCardIdByUserId ($user_id)
    {
        $userCard = self::findOne(['id_user' => $user_id]);
        if (empty($userCard)) {
            return null;
        }
        return $userCard['id'];

    }

    public static function getCardByUserRole($role): array
    {
        $auth = Yii::$app->authManager;
        $usersId = $auth->getUserIdsByRole($role);

        return UserCard::find()->where([ 'IN', 'id_user', $usersId])->all();
    }
}
