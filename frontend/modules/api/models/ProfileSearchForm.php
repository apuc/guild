<?php


namespace frontend\modules\api\models;


use backend\modules\card\models\UserCard;
use common\classes\Debug;
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


    public function checkIsArray()
    {
        if (!is_array($this->_task)) {
            $this->addError('_task', 'X is not array!');
        }
    }

    public function byId()
    {
        if ($this->id) {
            return UserCard::find()
                ->where(['id' => $this->id])
                ->with(['skillValues'])
                ->asArray()
                ->one();
        }

        return null;
    }

    public function byParams()
    {
        $model = UserCard::find()->select('user_card.id');


        if($this->skills){
            $model->joinWith(['skillValues']);
            $this->skills = explode(',', $this->skills);
            $model->where(['card_skill.skill_id' => $this->skills]);
            $model->having('COUNT(DISTINCT skill_id) = ' . count($this->skills));
        }
        else{
            $model->joinWith('skillValues');
        }

        $model->andFilterWhere(['position_id' => $this->position_id]);

        $model->andWhere(['status' => [4, 12]]);
        $model->andWhere(['deleted_at' => null]);

        $model->groupBy('card_skill.card_id');

        return $model->limit($this->limit)
            ->offset($this->offset)->orderBy('updated_at DESC')->asArray()->all();
    }

}