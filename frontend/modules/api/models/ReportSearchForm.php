<?php


namespace frontend\modules\api\models;

use common\models\Reports;
use frontend\modules\card\models\UserCard;
use yii\base\Model;

class ReportSearchForm extends Model
{
    public $limit;
    public $offset;
    public $fromDate;
    public $toDate;
    public $user_id;
    /**
     * @var false
     */
    public $byDate;

    public function __construct($config = [])
    {
        $this->limit = 10;
        $this->offset = 0;
        $this->user_id = null;

        $this->toDate = date('Y-m-d', time());
        $this->fromDate = date('Y-m-01', time());
        $this->byDate = false;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['byDate'], 'safe'],
            [['fromDate', 'toDate'], 'date', 'format' => 'php:Y-m-d'],
            [['limit', 'offset', 'user_id'], 'integer', 'min' => 0],
        ];
    }

    public function byParams()
    {
        $queryBuilder = Reports::find()
            ->with('task');

        if ($this->byDate) {
            $queryBuilder->andWhere(['reports.created_at' => $this->byDate]);
        } else {
            $queryBuilder->andWhere(['between', 'reports.created_at', $this->fromDate, $this->toDate]);
        }

        $queryBuilder->limit($this->limit)
            ->offset($this->offset);

        if (isset($this->user_id)) {
            $queryBuilder->andWhere(['user_card_id' => $this->user_id]);
        }

        $data = $queryBuilder->asArray()->all();

        return $data;
    }
}