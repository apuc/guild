<?php

namespace common\models;

use common\classes\Debug;
use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property int $id
 * @property string $created_at
 * @property string $today
 * @property string $difficulties
 * @property string $tomorrow
 * @property int $user_card_id
 * @property int $user_id
 * @property int $project_id
 * @property int $company_id
 * @property int $status
 *
 * @property UserCard $userCard
 */
class Reports extends \yii\db\ActiveRecord
{
    public $_task;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_card_id', 'user_id', 'status', 'company_id', 'project_id'], 'integer'],
            [['_task'], 'checkIsArray'],
            [['created_at'], 'required'],
            [['today', 'difficulties', 'tomorrow', 'created_at'], 'string', 'max' => 255],
            [['user_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCard::class, 'targetAttribute' => ['user_card_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['project_id'], 'exist', 'skipOnEmpty' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['company_id'], 'exist', 'skipOnEmpty' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата заполнения отчета',
            'today' => 'Что было сделано сегодня?',
            'difficulties' => 'Какие сложности возникли?',
            'tomorrow' => 'Что планируется сделать завтра?',
            'user_card_id' => 'Профиль пользователя',
            'user_id' => 'Пользователь',
            'status' => 'Статус',
            'project_id' => 'ID проекта',
            'company_id' => 'ID компании'
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveTask();
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->_task = [];
        if ($this->task) {
            $i = 0;
            foreach ($this->task as $task) {
                $this->_task[$i]['task'] = $task->task;
                $this->_task[$i]['hours_spent'] = $task->hours_spent;
                $this->_task[$i]['minutes_spent'] = $task->minutes_spent;
                $i++;
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCard()
    {
        return $this->hasOne(UserCard::className(), ['id' => 'user_card_id']);
    }

    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTask()
    {
        return $this->hasMany(ReportsTask::class, ['report_id' => 'id']);
    }

    public function saveTask()
    {
        ReportsTask::deleteAll(['report_id' => $this->id]);
        if ($this->_task) {
            foreach ($this->_task as $task) {
                $taskModel = new ReportsTask();
                $taskModel->report_id = $this->id;
                $taskModel->task = $task['task'];
                $taskModel->hours_spent = (float)$task['hours_spent'];
                $taskModel->minutes_spent = (int)$task['minutes_spent'];
                $taskModel->status = 1;
                $taskModel->created_at = time();
                $taskModel->save();
            }
        }
    }

    public function checkIsArray()
    {
        if (!is_array($this->_task)) {
            $this->addError('_task', 'X is not array!');
        }
    }

    public static function getFio($data)
    {
        $user_card = UserCard::findOne(['id_user' => $data->user_id]);
        return $user_card->fio ?? null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportsTask()
    {
        return $this->hasMany(ReportsTask::className(), ['report_id' => 'id']);
    }

    public function calculateOrderTime()
    {
        return ReportsTask::find()->where(['report_id' => $this->id])->sum('hours_spent');
    }
}
