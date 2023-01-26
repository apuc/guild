<?php

namespace backend\modules\task\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\task\models\ProjectTaskUser;

/**
 * TaskUserSearch represents the model behind the search form of `backend\modules\task\models\TaskUser`.
 */
class TaskUserSearch extends ProjectTaskUser
{
    public $projectId;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'project_user_id'], 'integer'],
            [['projectId'], 'safe']
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
        $query = ProjectTaskUser::find()->joinWith(['task', 'projectUser', 'projectUser.project', 'projectUser.user']);

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
            'task_id' => $this->task_id,
            'task_user.project_user_id' => $this->project_user_id,
        ]);

        $query->andFilterWhere(['like', 'project.id', $this->projectId]);

        return $dataProvider;
    }
}
