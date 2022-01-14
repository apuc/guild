<?php

namespace backend\modules\document\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\document\models\Template;

/**
 * TemplateSearch represents the model behind the search form of `backend\modules\document\models\Template`.
 */
class TemplateSearch extends Template
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'document_type'], 'integer'],
            [['title', 'document_type', 'created_at', 'updated_at', 'template_file_name'], 'safe'],
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
        $query = Template::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'template_file_name', $this->template_file_name])
            ->andFilterWhere(['like', 'document_type', $this->document_type]);

        return $dataProvider;
    }
}
