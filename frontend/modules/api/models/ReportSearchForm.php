<?php


namespace frontend\modules\api\models;

use common\models\Reports;
use common\models\ReportsTask;
use yii\base\Model;

class ReportSearchForm extends Model
{
    public $limit;
    public $offset;
    public $fromDate;
    public $toDate;
    public $user_card_id;
    /**
     * @var false
     */
    public $byDate;
    public $date;

    public function __construct($config = [])
    {
        $this->limit = 10;
        $this->offset = 0;
        $this->user_card_id = null;

        $this->toDate = date('Y-m-d', time());
        $this->fromDate = date('Y-m-d', time());
        $this->date = date('Y-m-d');
        $this->byDate = false;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['byDate'], 'safe'],
//            [['fromDate', 'toDate', 'date'], 'date', 'format' => 'Y-m-d'],
            [['limit', 'offset', 'user_card_id'], 'integer', 'min' => 0],
        ];
    }

    public function byParams()
    {
        $queryBuilder = Reports::find()
            ->with('task');

        if ($this->byDate) {
            $queryBuilder->andWhere(['reports.created_at' => $this->date]);
        } else {
            $queryBuilder->andWhere(['between', 'reports.created_at', $this->fromDate, $this->toDate]);
        }

        $queryBuilder->limit($this->limit)
            ->offset($this->offset);

        if (isset($this->user_card_id)) {
            $queryBuilder->andWhere(['user_card_id' => $this->user_card_id]);
        }

        $data = $queryBuilder->asArray()->all();

        return $data;
    }

    public function findByDate(): array
    {
        return Reports::find()
            ->where(['user_card_id' => $this->user_card_id])
            ->andWhere(['created_at' => $this->date])
            ->all();
    }
}