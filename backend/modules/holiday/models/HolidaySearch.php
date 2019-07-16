<?php

namespace backend\modules\holiday\models;

use common\classes\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class HolidaySearch extends Holiday
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_id'], 'integer'],
            [['card_id', 'dt_start', 'dt_end'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {

        $query = Holiday::find()->with('users');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dt_start = strtotime($this->dt_start) ? strtotime($this->dt_start) : null;
        $dt_end = strtotime($this->dt_end) ? strtotime($this->dt_end) : null;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'card_id' => $this->card_id,
        ]);

        $query->andFilterWhere(['between', 'dt_start', $dt_start, $dt_end ])
            ->orFilterWhere(['between', 'dt_end', $dt_start, $dt_end ]);

        return $dataProvider;
    }
}