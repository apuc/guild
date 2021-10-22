<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\questionnaire\models\UserQuestionnaire;

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
            [['uuid', 'created_at', 'updated_at'], 'safe'],
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
        $query = UserQuestionnaire::find();

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
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid]);

        return $dataProvider;
    }
}
