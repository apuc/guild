<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\questionnaire\models\QuestionType;

/**
 * QuestionTypeSearch represents the model behind the search form of `backend\modules\questionnaire\models\QuestionType`.
 */
class QuestionTypeSearch extends QuestionType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['question_type', 'slug'], 'safe'],
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
        $query = QuestionType::find();

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
        ]);

        $query->andFilterWhere(['like', 'question_type', $this->question_type])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
