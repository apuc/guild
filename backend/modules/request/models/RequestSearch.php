<?php

namespace backend\modules\request\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\request\models\Request;

/**
 * RequestSearch represents the model behind the search form of `backend\modules\request\models\Request`.
 */
class RequestSearch extends Request
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'position_id', 'knowledge_level_id', 'specialist_count', 'status'], 'integer'],
            [['created_at', 'updated_at', 'title', 'skill_ids', 'descr'], 'safe'],
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
        $query = Request::find();

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
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'position_id' => $this->position_id,
            'knowledge_level_id' => $this->knowledge_level_id,
            'specialist_count' => $this->specialist_count,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'skill_ids', $this->skill_ids])
            ->andFilterWhere(['like', 'descr', $this->descr]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
