<?php

namespace common\models;

use Exception;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project_user".
 *
 * @property int $id
 * @property int $card_id
 * @property int $project_id
 * @property int $user_id
 * @property int $project_role_id
 * @property int $status
 *
 * @property Project $project
 * @property UserCard $card
 * @property User $user
 * @property ProjectRole $projectRole
 * @property ProjectTaskUser[] $taskUsers
 */
class ProjectUser extends \yii\db\ActiveRecord
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    public static function statusList() :array
    {
        return [
            self::STATUS_INACTIVE => 'Не активен',
            self::STATUS_ACTIVE => 'Активен',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id', 'card_id'], 'required'],
            ['user_id', 'unique', 'targetAttribute' => ['user_id', 'project_id'], 'message'=>'Сотрудник уже назначен на этот проект'],
            ['card_id', 'unique', 'targetAttribute' => ['card_id', 'project_id'], 'message'=>'Сотрудник уже назначен на этот проект'],
            [['card_id', 'project_id', 'user_id', 'project_role_id', 'status'], 'integer'],
            [['status'], 'default', 'value'=> self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::class, 'targetAttribute' => ['card_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['project_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectRole::class, 'targetAttribute' => ['project_role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Карточка',
            'project_id' => 'Проект',
            'user_id' => 'Сотрудник',
            'project_role_id' => 'Роль на проекте',
            'status' => 'Статус'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(UserCard::class, ['id' => 'card_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(ProjectTask::class, ['project_user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasksByProject()
    {
        return $this->hasMany(ProjectTask::class, ['project_id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectRole(): ActiveQuery
    {
        return $this->hasOne(ProjectRole::class, ['id' => 'project_role_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(ProjectTaskUser::class, ['project_user_id' => 'id']);
    }

    public static function usersByProjectArr($project_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith('user')->where(['project_id' => $project_id])->all(), 'id', 'user.username');
    }

    public static function usersByTaskArr($task_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith(['tasksByProject', 'user'])->where(['task.id' => $task_id])->all(), 'id', 'user.username');
    }

    public static function userCardByTaskArr($task_id): array
    {
        return ArrayHelper::map(
            self::find()->joinWith(['tasksByProject', 'card'])->where(['task.id' => $task_id])->all(), 'id', 'card.fio');
    }

    public static function setUsersByCardId()
    {
        $projectUserModels = self::findAll(['user_id' => null]);

        foreach ($projectUserModels as $projectUser)
        {
            $projectUser->user_id = UserCard::getUserIdByCardId($projectUser->card_id);
            if ($projectUser->user_id !== null) {
                $projectUser->save();
            }
        }
    }

    public static function setCardsByUsersId()
    {
        $projectUserModels = self::findAll(['card_id' => null]);

        foreach ($projectUserModels as $projectUser)
        {
            $projectUser->card_id = UserCard::getCardIdByUserId($projectUser->user_id);
            if ($projectUser->card_id !== null) {
                $projectUser->save();
            }
        }
    }

    public static function getUsersNotOnProject($project_id): array
    {
        $usersIdList = ProjectUser::find()->where(['project_id' => $project_id])->select('card_id')->column();

        $userCards = UserCard::find()
            ->where(['not in', 'id', $usersIdList])
            ->andWhere(['not', ['id_user' => null]])
            ->all();
        return ArrayHelper::map($userCards, 'id', 'fio');
    }
}
