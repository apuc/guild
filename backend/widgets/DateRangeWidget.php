<?php


namespace backend\widgets;


use yii\base\Widget;

class DateRangeWidget extends Widget
{
    public $model;

    public function run()
    {
        return $this->render('date_range', ['model' => $this->model]);
    }

}