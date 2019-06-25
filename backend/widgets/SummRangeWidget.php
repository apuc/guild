<?php


namespace backend\widgets;


use common\classes\Debug;
use yii\base\Widget;

class SummRangeWidget extends Widget
{
    public $model;
    public $range_attribute;

    public function run()
    {
        return $this->render('summ_range', ['model' => $this->model]);
    }

}