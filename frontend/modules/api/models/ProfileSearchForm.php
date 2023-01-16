<?php


namespace frontend\modules\api\models;


use yii\base\Model;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * Class ProfileSearchForm
 * @property integer $limit
 * @property integer $offset
 * @property integer $card_id
 * @package frontend\modules\api\models
 */
class ProfileSearchForm extends Model implements Linkable
{
    public $limit = 10;
    public $offset = 0;
    public $skills;

    public $position_id;
    public $card_id;

    public function rules()
    {
        return [
            [['card_id', 'limit', 'offset', 'position_id'], 'safe'],
            [['skills'], 'checkIsArray'],
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['index', 'card_id' => $this->id], true),
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
        return UserCard::find()
            ->where(['id' => $this->card_id]);
    }

    public function byParams()
    {
        $model = UserCard::find()
            ->filterWhere(['position_id' => $this->position_id])
            ->where(['status' => [4, 12]])
            ->andWhere(['deleted_at' => null]);

        if ($this->skills) {
            $model->joinWith(['skillValues']);
            $this->skills = explode(',', $this->skills);
            $model->where(['card_skill.skill_id' => $this->skills]);
            $model->having('COUNT(DISTINCT skill_id) = ' . count($this->skills));
            $model->groupBy('card_skill.card_id');
        }

        return $model->orderBy('updated_at DESC');
    }
}