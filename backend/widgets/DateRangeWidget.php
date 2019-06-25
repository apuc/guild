<?php


namespace backend\widgets;


use common\classes\Debug;
use yii\base\Widget;

class DateRangeWidget extends Widget
{
    public $model;
    public $range_attribute;

    public function run()
    {
        return $this->render('date_range', ['model' => $this->model]);
    }

}