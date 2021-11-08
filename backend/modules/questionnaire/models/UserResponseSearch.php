<?php

namespace backend\modules\questionnaire\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\questionnaire\models\UserResponse;

/**
 * UserResponseSearch represents the model behind the search form of `backend\modules\questionnaire\models\UserResponse`.
 */
class UserResponseSearch extends UserResponse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'question_id', 'user_questionnaire_id'], 'integer'],
            [['response_body', 'created_at', 'updated_at'], 'safe'],
            [['answer_flag'], 'number'],
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
        $query = UserResponse::find()->with('user');

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
            'user_id' => $this->user_id,
            'question_id' => $this->question_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'answer_flag' => $this->answer_flag,
            'user_questionnaire_id' => $this->user_questionnaire_id,
        ]);

        $query->andFilterWhere(['like', 'response_body', $this->response_body]);

        return $dataProvider;
    }
}
