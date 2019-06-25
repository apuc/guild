<?php

namespace backend\modules\balance\models;

use common\classes\Debug;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\balance\models\Balance;

/**
 * BalanceSearch represents the model behind the search form of `backend\modules\balance\models\Balance`.
 */
class BalanceSearch extends Balance
{
    public $summ_from;
    public $summ_to;
    public $dt_from;
    public $dt_to;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'summ', 'summ_from', 'summ_to'], 'integer'],
            [['dt_from', 'dt_to', 'dt_add'], 'safe'],
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
        $query = Balance::find();

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
            'type' => $this->type,
            //'summ' => $this->summ,
            'dt_add' => $this->dt_add,
        ]);

        //Debug::dd($this);

        if($this->dt_from && $this->dt_to){
            $query->where(['between', 'dt_add', strtotime($this->$this->dt_from), strtotime($this->$this->dt_to)]);
        }
        if($this->dt_from){
            $query->where(['>', 'dt_add', strtotime($this->$this->dt_from)]);
        }

        $summ_from = $this->summ_from ?: 0;
        $summ_to = $this->summ_to ?: 9999999999;

        $query->andFilterWhere(['between', 'summ', $summ_from, $summ_to]);

        return $dataProvider;
    }
}
