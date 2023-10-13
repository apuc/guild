<?php

namespace backend\modules\task\models;

use backend\modules\project\models\ProjectUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\task\models\ProjectTask;

/**
 * TaskSearch represents the model behind the search form of `backend\modules\task\models\Task`.
 */
class ProjectTaskSearch extends ProjectTask
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'status'], 'integer'], // 'card_id_creator', 'card_id'
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
            'project_task.project_id' => $this->project_id,
            'project_task.status' => $this->status,
            'project_task.execution_priority' => $this->execution_priority,
            'project_task.created_at' => $this->created_at,
            'project_task.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'project_task.description', $this->description]);

        return $dataProvider;
    }
}
