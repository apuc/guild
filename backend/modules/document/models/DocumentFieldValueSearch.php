<?php

namespace backend\modules\document\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\document\models\DocumentFieldValue;

/**
 * DocumentFieldValueSearch represents the model behind the search form of `backend\modules\document\models\DocumentFieldValue`.
 */
class DocumentFieldValueSearch extends DocumentFieldValue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'field_id', 'document_id'], 'integer'],
            [['value'], 'safe'],
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
        $query = DocumentFieldValue::find();

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
            'field_id' => $this->field_id,
            'document_id' => $this->document_id,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
