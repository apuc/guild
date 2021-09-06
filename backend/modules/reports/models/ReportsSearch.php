<?php

namespace backend\modules\reports\models;

use common\classes\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reports;


/**
 * ReportsSearch represents the model behind the search form of `common\models\Reports`.
 */
class ReportsSearch extends Reports
{
    public $fio;
    public $month;
    public $year;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'user_card_id'], 'integer'],
            [['today', 'difficulties', 'tomorrow', 'fio'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Reports::find()
            ->leftJoin('user_card', 'reports.user_card_id = user_card.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);


        if (isset($params['date']) and preg_match("/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $params['date']) and !isset($params['id'])) {
            $this->created_at = $params['date'];
        }

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//
//            return $dataProvider;
//        }

        // grid filtering conditions


//        Debug::dd($params['date']);

        $query->andFilterWhere([
            'user_card.id' => $this->id,
            'reports.created_at' => $this->created_at,
            'user_card_id' => $this->user_card_id,
        ]);

        $query->andFilterWhere(['like', 'today', $this->today])
            ->andFilterWhere(['like', 'difficulties', $this->difficulties])
            ->andFilterWhere(['like', 'tomorrow', $this->tomorrow])
            ->andFilterWhere(['like', 'user_card.fio', $this->fio])
            ->andFilterWhere(['=', 'YEAR(reports.created_at)', $this->year])
            ->andFilterWhere(['=', 'MONTH(reports.created_at)', $this->month]);


        return $dataProvider;
    }
}
