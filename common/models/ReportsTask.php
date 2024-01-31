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
 * @property int $minutes_spent
 * @property float $hours_spent
 *
 * @property Reports $report
 */
class ReportsTask extends \yii\db\ActiveRecord
{
//    const SCENARIO_WITHOUT_REPORT_ID = 'withoutReportID';
//
//    public function scenarios()
//    {
//        $scenarios = parent::scenarios();
//        $scenarios[self::SCENARIO_WITHOUT_REPORT_ID] = self::attributes();
//        return $scenarios;
//    }

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
            //[['report_id'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['report_id', 'created_at', 'status', 'minutes_spent'], 'integer'],
            [['hours_spent'], 'number'],
            ['minutes_spent', 'compare', 'compareValue' => 60, 'operator' => '<'],
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
