<?php

namespace backend\modules\card\models;

use common\classes\Debug;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserCardSearch represents the model behind the search form of `backend\modules\card\models\UserCard`.
 */
class UserCardSearch extends UserCard
{
    public $skills;
    public $total;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'status'], 'integer'],
            [['fio', 'passport', 'photo', 'email', 'dob', 'created_at', 'updated_at', 'city', 'test_task_getting_date', 'test_task_complete_date'], 'safe'],
            ['skills', 'each', 'rule' => ['integer']],
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
        $query = UserCard::find();
        $query->where(['id'])->distinct()
            ->leftJoin('card_skill', 'card_skill.card_id=user_card.id')
            ->leftJoin('skill', 'skill.id=card_skill.skill_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['deleted_at' => null]);

        if (isset($params['month'])) {
            $query->andFilterWhere(['=', 'MONTH(dob)', $params['month']]);
        }
        if (isset($params['day'])) {
            $query->andFilterWhere(['=', 'DAY(dob)', $params['day']]);
        }
        if (isset($params['date'])) {
            $query->andFilterWhere(['=', 'MONTH(dob)', substr($params['date'], 5,2)]);
            $query->andFilterWhere(['=', 'DAY(dob)', substr($params['date'],8,2)]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'status' => $this->status,
            'city' => $this->city,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'test_task_getting_date' => $this->test_task_getting_date,
            'test_task_complete_date' => $this->test_task_complete_date,
            'resume_tariff' => $this->resume_tariff,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'email', $this->email]);

        $query->andFilterWhere(['skill.id' => $this->skills]);

        $query->orderBy('user_card.updated_at DESC');

//        $query->groupBy('card_skill.card_id');

        $sumQuery = clone $query;

        $this->total = $sumQuery->sum('salary');

        return $dataProvider;
    }
}
