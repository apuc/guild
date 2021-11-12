<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AnswerSearch represents the model behind the search form of `backend\modules\questionnaire\models\Answer`.
 */
class AnswerSearch extends Answer
{
    public $questionnaire;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'question_id', 'answer_flag', 'status'], 'integer'],
            [['answer_body', 'questionnaire', 'created_at', 'updated_at'], 'safe'],
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
        $query = Answer::find()->with('question')->joinWith('questionnaire');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['title'] = [
            'asc' => ['questionnaire.title' => SORT_ASC],
            'desc' => ['questionnaire.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'question_id' => $this->question_id,
            'answer_flag' => $this->answer_flag,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'answer_body', $this->answer_body]);

        $query->joinWith(['questionnaire' => function($q) {
            $q->andFilterWhere(['like', 'questionnaire.id', $this->questionnaire]);
        }]);

        return $dataProvider;
    }
}
