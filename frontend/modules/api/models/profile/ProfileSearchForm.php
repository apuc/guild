<?php


namespace frontend\modules\api\models\profile;


use backend\modules\card\models\UserCard;
use yii\base\Model;

/**
 * Class ProfileSearchForm
 * @property integer $limit
 * @property integer $offset
 * @property integer $id
 * @package frontend\modules\api\models
 */
class ProfileSearchForm extends Model
{
    public $limit = 10;
    public $offset = 0;
    public $skills;

    public $position_id;
    public $id;

    public function rules()
    {
        return [
            [['id', 'limit', 'offset', 'position_id'], 'safe'],
            [['skills'], 'checkIsArray'],
        ];
    }

    public function exclude($arr)
    {
        $ex = ['passport', 'resume', 'link_vk', 'link_telegram', 'email', 'salary'];
        foreach ($ex as $remove) {
            if (isset($arr[$remove])) {
                unset($arr[$remove]);
            }
        }

        return $arr;
    }


    public function checkIsArray()
    {
        if (!is_array($this->_task)) {
            $this->addError('_task', 'X is not array!');
        }
    }

    public function byId()
    {
        if ($this->id) {
            $model = $this->exclude(UserCard::find()
                ->where(['id' => $this->id])
                ->with(['position'])
                ->with(['skillValues'])
                ->with(['achievements'])
                ->asArray()
                ->one());
            $model['level_title'] = \common\models\UserCard::getLevelList()[$model['level']];

            return $model;
        }

        return null;
    }

    public function byParams()
    {
        $model = UserCard::find();

        if ($this->skills) {
            $model->joinWith(['skillValues', 'position']);
            $this->skills = explode(',', $this->skills);
            $model->where(['card_skill.skill_id' => $this->skills]);
            $model->having('COUNT(DISTINCT skill_id) = ' . count($this->skills));
        } else {
            $model->joinWith('skillValues');
        }

        $model->joinWith('achievements');

        $model->andFilterWhere(['position_id' => $this->position_id]);

        $model->andWhere(['status' => [4, 12]]);
        $model->andWhere(['deleted_at' => null]);

        //$model->groupBy('card_skill.card_id');

        $res = $model->limit($this->limit)
            ->offset($this->offset)->orderBy('updated_at DESC')->asArray()->all();

        if(!$res){
            return [];
        }

        $resArr = [];
        foreach ($res as $re){
            $resArr[] = $this->exclude($re);
        }
        $resArr['level_title'] = \common\models\UserCard::getLevelList()[$model->level];

        return $resArr;
    }

}