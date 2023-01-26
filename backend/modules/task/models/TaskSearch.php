<?php

namespace backend\modules\task\models;

use backend\modules\project\models\ProjectUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\task\models\ProjectTask;

/**
 * TaskSearch represents the model behind the search form of `backend\modules\task\models\Task`.
 */
class TaskSearch extends ProjectTask
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'status', 'card_id_creator', 'card_id'], 'integer'], // 'card_id_creator', 'card_id'
            [['title', 'created_at', 'updated_at', 'description'], 'safe'],
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
        $query = ProjectTask::find();//->joinWith(['user_card', 'project']);

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
            'task.project_id' => $this->project_id,
            'task.status' => $this->status,
            'task.created_at' => $this->created_at,
            'task.updated_at' => $this->updated_at,
            'task.card_id_creator' => $this->card_id_creator,
            'task.card_id' => $this->card_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'task.description', $this->description]);

        return $dataProvider;
    }
}
