<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserQuestionnaireSearch represents the model behind the search form of `backend\modules\questionnaire\models\UserQuestionnaire`.
 */
class UserQuestionnaireSearch extends UserQuestionnaire
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'questionnaire_id', 'user_id', 'score', 'status'], 'integer'],
            [['uuid', 'created_at', 'updated_at', 'testing_date'], 'safe'],
            [['percent_correct_answers'], 'number'],
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
        $query = UserQuestionnaire::find()->with('questionnaire', 'user');

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
            'questionnaire_id' => $this->questionnaire_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'score' => $this->score,
            'status' => $this->status,
            'percent_correct_answers' => $this->percent_correct_answers,
            'testing_date' => $this->testing_date,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid]);

        return $dataProvider;
    }
}
