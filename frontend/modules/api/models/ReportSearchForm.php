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

    public function __construct($config = [])
    {
        $this->limit = 10;
        $this->offset = 0;
        $this->user_id = null;

        $this->toDate = date('Y-m-d', time());
        $this->fromDate = date('Y-m-01', time());

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
          [['fromDate', 'toDate'], 'date', 'format' => 'php:Y-m-d'],
          [['limit', 'offset', 'user_id'], 'integer', 'min' => 0],
        ];
    }

    public function byParams()
    {
        $queryBuilder = Reports::find()
            ->andWhere(['between', 'created_at', $this->fromDate, $this->toDate, $this->user_id])
            ->limit($this->limit)
            ->offset($this->offset);

        if(isset($this->user_id)) {
            $userCardId = UserCard::findByUserId($this->user_id)->id;
            $queryBuilder->andWhere(['user_card_id' => $userCardId]);
        }

        $data = $queryBuilder->all();

        return $data;
    }
}