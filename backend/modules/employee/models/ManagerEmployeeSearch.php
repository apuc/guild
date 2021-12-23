<?php

namespace backend\modules\employee\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\employee\models\ManagerEmployee;

/**
 * ManagerEmployeeSearch represents the model behind the search form of `backend\modules\employee\models\ManagerEmployee`.
 */
class ManagerEmployeeSearch extends ManagerEmployee
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'manager_id', 'user_card_id'], 'integer'],
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
        $query = ManagerEmployee::find()->joinWith(['userCard', 'manager']);

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
            'manager_id' => $this->manager_id,
            'user_card_id' => $this->user_card_id,
        ]);

        return $dataProvider;
    }
}
