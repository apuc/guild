<?php

namespace backend\modules\company\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\company\models\CompanyManager;

/**
 * CompanyManagerSearch represents the model behind the search form of `backend\modules\company\models\CompanyManager`.
 */
class CompanyManagerSearch extends CompanyManager
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'user_card_id'], 'integer'],
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
        $query = CompanyManager::find()->where(['not', ['company_id' => null]]);

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
            'company_id' => $this->company_id,
            'user_card_id' => $this->user_card_id,
        ]);

        return $dataProvider;
    }
}
