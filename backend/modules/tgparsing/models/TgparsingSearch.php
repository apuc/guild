<?php

namespace backend\modules\tgparsing\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\tgparsing\models\Tgparsing;

/**
 * TgparsingSearch represents the model behind the search form of `backend\modules\tgparsing\models\Tgparsing`.
 */
class TgparsingSearch extends Tgparsing
{
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            [['id', 'channel_id', 'status', 'post_id'], 'integer'],
            [['channel_title', 'channel_link', 'content', 'created_at', 'updated_at'], 'safe'],
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
        $query = Tgparsing::find();

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
            'channel_id' => $this->channel_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'channel_title', $this->channel_title])
            ->andFilterWhere(['like', 'content', $this->content]);

        $query->orderBy("id DESC");

        return $dataProvider;
    }
}
