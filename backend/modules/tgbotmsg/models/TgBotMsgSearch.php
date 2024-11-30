<?php

namespace backend\modules\tgbotmsg\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\tgbotmsg\models\TgBotMsg;

/**
 * TgBotMsgSearch represents the model behind the search form of `backend\modules\tgbotmsg\models\TgBotMsg`.
 */
class TgBotMsgSearch extends TgBotMsg
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dialog_id', 'ig_dialog_id'], 'integer'],
            [['text', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = TgBotMsg::find();

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
            'dialog_id' => $this->dialog_id,
            'ig_dialog_id' => $this->ig_dialog_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
