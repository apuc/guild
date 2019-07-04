<?php

namespace backend\modules\hh\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\hh\models\HhJob;

/**
 * HhJobSearch represents the model behind the search form of `backend\modules\hh\models\HhJob`.
 */
class HhJobSearch extends HhJob
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employer_id', 'hh_id', 'salary_from', 'salary_to', 'dt_add'], 'integer'],
            [['title', 'url', 'salary_currency', 'address'], 'safe'],
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
        $query = HhJob::find()->joinWith('hhcompany');

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
            'employer_id' => $this->employer_id,
            'hh_id' => $this->hh_id,
            'salary_from' => $this->salary_from,
            'salary_to' => $this->salary_to,
            'dt_add' => $this->dt_add,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'salary_currency', $this->salary_currency])
            ->andFilterWhere(['like', 'address', $this->address]);
        $query->orderBy('dt_add DESC');

        return $dataProvider;
    }
}
