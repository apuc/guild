<?php


namespace frontend\modules\api\models;

use common\models\Reports;
use yii\base\Model;

/**  */
class ReportSearchForm extends Model
{
    public $user_card_id;
    public $limit;
    public $offset;
    /** @var string  */
    public $date;
    public $fromDate;
    public $toDate;

    public function __construct($config = [])
    {
        $this->limit = 10;
        $this->offset = 0;
        $this->user_card_id = null;

        $this->toDate = date('Y-m-d');
        $this->fromDate = date('Y-m-d');
        $this->date = date('Y-m-d');

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['byDate'], 'safe'],
            [['fromDate', 'toDate', 'date'], 'string'],
//            [['fromDate', 'toDate', 'date'], 'date', 'format' => 'php:Y-m-d'],
            [[ 'user_card_id'], 'integer', 'min' => 0],
        ];
    }

    public function byParams()
    {
        $queryBuilder = Reports::find()->with('task');

        if ($this->fromDate && $this->toDate) {
            $queryBuilder->andWhere(['between', 'reports.created_at', $this->fromDate, $this->toDate]);
        }

        if (isset($this->user_card_id)) {
            $queryBuilder->andWhere(['reports.user_card_id' => $this->user_card_id]);
        }

        $queryBuilder->limit($this->limit)
            ->offset($this->offset);

        return $queryBuilder->asArray()->all();
    }

    public function findByDate()
    {
        return Reports::find()->with('task')
            ->where(['reports.user_card_id' => $this->user_card_id])
//            ->where(['between', 'reports.created_at', $this->fromDate, $this->toDate])
            ->andWhere(['reports.created_at' => $this->date])
            ->asArray()->all();
    }

    public function reportsByDate()
    {
        return Reports::find()->with('task')
            ->where(['reports.user_card_id' => $this->user_card_id])
            ->where(['reports.user_card_id' => $this->user_card_id])
            ->where(['between', 'reports.created_at', $this->fromDate, $this->toDate])
            ->asArray()->all();
    }
}