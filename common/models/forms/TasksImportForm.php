<?php

namespace common\models\forms;
use yii\base\Model;

class TasksImportForm extends Model
{
    public $companyId;
    public $userId;
    public $projectId;
    public $fromDate;
    public $toDate;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['companyId', 'userId', 'projectId'], 'integer'],
            ['fromDate', 'date', 'format' => 'php:Y-m-d', 'timestampAttribute' => 'fromDate'],
            ['toDate', 'date', 'format' => 'php:Y-m-d', 'timestampAttribute' => 'toDate'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'companyId' => 'ID компании',
            'userId' => 'ID пользователя',
            'projectId' => 'ID проекта',
            'fromDate' => 'Дата начала поиска',
            'toDate' => 'Дата конца поиска',
        ];
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }
}
