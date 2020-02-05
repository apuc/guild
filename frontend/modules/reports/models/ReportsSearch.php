<?php

namespace frontend\modules\reports\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reports;

/**
 * ReportsSearch represents the model behind the search form of `common\models\Reports`.
 */
class ReportsSearch extends Reports
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'user_card_id', 'status'], 'integer'],
            [['today', 'difficulties', 'tomorrow'], 'safe'],
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
        $query = Reports::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'user_card_id' => $this->user_card_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'today', $this->today])
            ->andFilterWhere(['like', 'difficulties', $this->difficulties])
            ->andFilterWhere(['like', 'tomorrow', $this->tomorrow]);

        return $dataProvider;
    }
}
