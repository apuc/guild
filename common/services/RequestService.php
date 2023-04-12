<?php

namespace common\services;

use common\classes\Debug;
use common\models\CardSkill;
use common\models\Request;
use common\models\UserCard;
use yii\helpers\ArrayHelper;

class RequestService
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var Request
     */
    public Request $model;

    /**
     * @var array
     */
    public array $errors = [];

    /**
     * @var bool
     */
    public bool $isSave = false;

    /**
     * @var bool
     */
    public bool $isLoad = false;

    /**
     * @var array
     */
    private array $excludePool = [];

    /**
     * @var bool
     */
    private bool $skillsFullEntry = true;

    /**
     * @var bool
     */
    private bool $cardAsArray = true;

    /**
     * @var bool
     */
    private bool $checkCardLevel = true;

    /**
     * @var bool
     */
    private bool $useCardExcludePool = false;

    /**
     * @var bool
     */
    private bool $checkCardPosition = true;

    /**
     * @var bool
     */
    private bool $returnCount = false;


    public function __construct(int $id = null)
    {
        if ($id) {
            $this->id = $id;
            $this->model = Request::findOne($id);
        } else {
            $this->model = new Request();
        }
    }

    /**
     * @param array $params
     * @return RequestService
     */
    public function save(array $params = []): RequestService
    {
        //$this->model->load($params);
        if ($this->model->validate()) {
            $this->isSave = $this->model->save();
            $this->id = $this->model->id;
        } else {
            $this->errors = $this->model->errors;
        }

        return $this;
    }

    /**
     * @param array $params
     * @return RequestService
     */
    public function load(array $params, $formName = "Request"): RequestService
    {
        if ($this->model->load($params, $formName)) {
            $this->isLoad = true;
        }

        return $this;
    }

    /**
     * @return Request|null
     */
    public function getModel(): ?Request
    {
        return $this->model;
    }

    /**
     * @return bool
     */
    public function isFind(): bool
    {
        if ($this->model->id) {
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return array|Request|null
     */
    public function getById()
    {
        return $this->model->find()->where(['id' => $this->id])->one();
    }

    /**
     * @param $user_id
     * @return array|Request|\yii\db\ActiveRecord[]
     */
    public function getByUserId($user_id)
    {
        return $this->model->find()->where(['user_id' => $user_id])->all();
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId): RequestService
    {
        $this->model->user_id = $userId;

        return $this;
    }

    /**
     * @return array|int
     */
    public function _search()
    {
        $model = $this->getById($this->id);
        $subQ = false;
        if (!empty($model->skill_ids)) {
            $subQ = CardSkill::find()->select('card_skill.card_id')
                ->where(['skill_id' => $model->skill_ids])
                ->groupBy('card_id HAVING COUNT(DISTINCT skill_id) = :count')
                ->addParams([':count' => count($model->skill_ids)]);
        }


        $q = UserCard::find()->select('user_card.id, fio, user_card.position_id, card_skill.skill_id')
            ->leftJoin('card_skill', 'card_skill.card_id = user_card.id')
            ->where(['deleted_at' => null])
            ->andWhere(['status' => [4, 12]])
            ->andWhere(['not', ['position_id' => null]]);

        if ($this->checkCardPosition) {
            $q->andWhere(['position_id' => $model->position_id]);
        }

        if ($this->checkCardLevel) {
            $q->andWhere(['level' => $model->knowledge_level_id]);
        }

        if ($this->skillsFullEntry && $subQ) {
            $q->andWhere(['user_card.id' => $subQ]);
        }

        if ($model->skill_ids) {
            $q->andWhere(['card_skill.skill_id' => $model->skill_ids]);
        }

        if ($this->useCardExcludePool) {
            $q->andWhere(['not', ['user_card.id' => $this->excludePool]]);
        }

        $q->groupBy('user_card.id');

        if ($this->cardAsArray) {
            $q->asArray();
        }

        if ($this->returnCount) {
            return $q->count();
        } else {
            $cards = $q->all();
        }

        if (is_array($cards)) {
            $this->excludePool = array_merge($this->excludePool, ArrayHelper::getColumn($cards, 'id'));
        }

        return $cards;
    }

    /**
     * @param int $searchDepth
     * @return array|int
     */
    public function search(int $searchDepth = 0)
    {
        $cards = $this->_search();
        $res = [];

        if ($searchDepth === 1) {
            $res = $this->checkLevel(false)->useExcludePool()->_search();
        }

        if ($searchDepth === 2) {
            $res = $this->checkLevel(false)->checkPosition(false)->useExcludePool()->_search();
        }

        if ($searchDepth === 3) {
            $res = $this->checkLevel(false)->checkPosition(false)->setSkillsFullEntry(false)->useExcludePool()->_search();
        }

        if ($this->returnCount) {
            if (is_array($res)) {
                return $cards;
            }
            return $res;
        }

        return array_merge($cards, $res);
    }


    /**
     * @param bool $value
     * @return $this
     */
    public function setSkillsFullEntry(bool $value): RequestService
    {
        $this->skillsFullEntry = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function asArray(bool $value = true): RequestService
    {
        $this->cardAsArray = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function checkLevel(bool $value = true): RequestService
    {
        $this->checkCardLevel = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function checkPosition(bool $value = true): RequestService
    {
        $this->checkCardPosition = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function useExcludePool(bool $value = true): RequestService
    {
        $this->useCardExcludePool = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function count(bool $value = true): RequestService
    {
        $this->returnCount = $value;

        return $this;
    }

    public static function q()
    {


    }

    /**
     * @param int|null $id
     * @return RequestService
     */
    public static function run(int $id = null): RequestService
    {
        return new self($id);
    }

}