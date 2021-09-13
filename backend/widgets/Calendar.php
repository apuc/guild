<?php

namespace backend\widgets;


use yii\base\Widget;
use yii\helpers\Html;


class Calendar extends Widget
{
    public $button;

    public $css;

    public $runBuild = 'function (date, content){
        this.build(date, content)
    }';

    public $updateContent = "function(){
        return [];
        /*
        Example, return [model1, model2, model3 , ...] : 
        
        let monthNumber = date.substr(5, 2);
        return fetch('../ajax/get-birthday-by-month?' +
            'month=' + monthNumber)
            .then((res) => {
                return res.json()
            })*/
    }";

    public $getColor = "function (date, dates = null) {
        return `className`; 
        }";

    public $getHtmlContentForDate = 'function (content, date) {
        return `<div class="content">${content}</div>`;
    }';

    public $script = 'CalendarHelper.main()';

    public function init()
    {
        parent::init();
        $view = $this->getView();
        AppAsset::register($view);
    }

    public function run()
    {
        echo Html::beginTag('section', ['class' => 'calendar-contain']);
            echo Html::beginTag('aside', ['class' => 'calendar__sidebar']);
                echo Html::beginTag('section', ['class' => 'title-bar']);
                    echo $this->button;
                    echo Html::input('date', null, date('Y-m-d'), ['class' => 'form-control', 'id' => 'date',]);
                echo Html::endTag('section');
                echo Html::tag('h2', date('l') . '<br>' . date('F d'), ['class' => 'sidebar__heading']);
                echo Html::beginTag('ul', ['class' => 'sidebar__list']);
                echo Html::endTag('ul');
            echo Html::endTag('aside');
            echo Html::beginTag('section', ['class' => 'calendar__days']);
            echo Html::endTag('section');
        echo Html::endTag('section');

        $this->view->registerJs('
            CalendarHelper._runBuild = ' . $this->runBuild . ';
            CalendarHelper._getHtmlContentForDate = ' . $this->getHtmlContentForDate . ';
            CalendarHelper._updateContent = async ' . $this->updateContent . ';
            CalendarHelper._getColor = ' . $this->getColor . ';
            
            '.$this->script
        );
        $this->view->registerCss($this->css);
    }

}
?>

