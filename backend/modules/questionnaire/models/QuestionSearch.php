<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\questionnaire\models\Question;

/**
 * QuestionSearch represents the model behind the search form of `backend\modules\questionnaire\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'question_type_id', 'questionnaire_id', 'question_priority', 'next_question', 'status', 'score'], 'integer'],
            [['question_body', 'created_at', 'updated_at', 'time_limit'], 'safe'],
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
        $query = Question::find();

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
            'question_type_id' => $this->question_type_id,
            'questionnaire_id' => $this->questionnaire_id,
            'question_priority' => $this->question_priority,
            'next_question' => $this->next_question,
            'status' => $this->status,
            'score' => $this->score,
            'time_limit' => $this->time_limit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'question_body', $this->question_body]);

        return $dataProvider;
    }
}
