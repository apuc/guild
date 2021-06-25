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
    public $id;

    public function rules()
    {
        return [
            [['id', 'limit', 'offset'], 'safe'],
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
        $model = UserCard::find();


        if($this->skills){
            $model->joinWith(['skillValues']);
            Debug::prn(123);
            $this->skills = explode(',', $this->skills);
            $model->where(['card_skill.skill_id' => $this->skills]);
        }
        else{
            $model->with('skillValues');
        }

        return $model->limit($this->limit)
            ->offset($this->offset)->asArray()->all();
    }

}