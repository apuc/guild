<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reports_task".
 *
 * @property int $id
 * @property int $report_id
 * @property string $task
 * @property int $created_at
 * @property int $status
 * @property float $hours_spent
 *
 * @property Reports $report
 */
class ReportsTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reports_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id'], 'required'],
            [['report_id', 'created_at', 'status'], 'integer'],
            [['hours_spent'], 'number'],
            [['task'], 'string'],
            [['report_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reports::className(), 'targetAttribute' => ['report_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'task' => 'Task',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Reports::className(), ['id' => 'report_id']);
    }
}
