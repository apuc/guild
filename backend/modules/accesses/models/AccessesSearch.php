<?php

namespace app\modules\accesses\models;

use common\classes\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Accesses;

/**
 * AccessesSearch represents the model behind the search form of `common\models\Accesses`.
 */
class AccessesSearch extends Accesses
{
    public $fio;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'login', 'password', 'link', 'project', 'info', 'fio'], 'safe'],
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
        //Debug::dd($params);
        $query = Accesses::find()
            ->leftJoin('user_card_accesses', 'accesses.id = user_card_accesses.accesses_id')
            ->leftJoin('user_card', 'user_card_accesses.user_card_id = user_card.id')
            ->orderBy('user_card.fio asc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'project', $this->project])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
