<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\questionnaire\models\Questionnaire;

/**
 * QuestionnaireSearch represents the model behind the search form of `backend\modules\questionnaire\models\Questionnaire`.
 */
class QuestionnaireSearch extends Questionnaire
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'status', 'time_limit'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'safe'],
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
        $query = Questionnaire::find()->with('category');

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
            'category_id' => $this->category_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'time_limit' => $this->time_limit,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
