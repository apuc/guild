<?php

namespace backend\modules\card\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\card\models\UserCard;

/**
 * UserCardSearch represents the model behind the search form of `backend\modules\card\models\UserCard`.
 */
class UserCardSearch extends UserCard
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'status'], 'integer'],
            [['fio', 'passport', 'photo', 'email', 'dob', 'created_at', 'updated_at'], 'safe'],
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

        $query->where(['deleted_at' => null]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
