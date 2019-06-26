<?php


namespace backend\widgets;


use yii\base\Widget;

class AdditionalFieldsFilterWidget extends Widget
{
    public $model;

    public function run()
    {
        return $this->render('additional_fields_filter', ['model' => $this->model]);
    }

}