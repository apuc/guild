<?php

namespace backend\modules\achievements\models;

use common\models\Achievement;
use Yii;
use yii\data\ActiveDataProvider;

class AchievementSearch extends Achievement
{

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'description', 'slug', 'title','img'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $params = Yii::$app->request->queryParams;
        $query = Achievement::find();
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
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'title', $this->title]);
//        $query->orderBy('created_at DESC');

        return $dataProvider;
    }
}
