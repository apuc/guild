<?php

namespace backend\modules\hh\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\hh\models\Hh;

/**
 * HhSearch represents the model behind the search form of `backend\modules\hh\models\Hh`.
 */
class HhSearch extends Hh
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'hh_id', 'dt_add'], 'integer'],
            [['url', 'title', 'photo'], 'safe'],
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
        $query = Hh::find();

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
            'hh_id' => $this->hh_id,
            'dt_add' => $this->dt_add,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'photo', $this->photo]);
        $query->orderBy('dt_add DESC');

        return $dataProvider;
    }
}
