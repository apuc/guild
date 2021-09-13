<?php

namespace backend\widgets;


use yii\base\Widget;
use yii\helpers\Html;


class Calendar extends Widget
{
    public $button;

    public $css;

    public $dayUpdate;

    public $monthUpdate;

    public $colorClasses = ['accept' => 'access', 'default' => 'danger', 'offDay' => ''];

    public $offDaysShow = 1;

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
            CalendarHelper._getDayContent = async function(date){
                let url =  `'.$this->dayUpdate['url'].'?`;
                '.(isset($this->dayUpdate['data'])?'
                let data = '.json_encode($this->dayUpdate['data']):'
                let data = {};
                    ').'
                if(Object.keys(data).length){
                    for (let key in data){
                        url += key+`=`+ data[key]+`&`
                    }
                }
                return fetch(url+
                `date=` + DateHelper.dateToString(date))
                .then((res) => {
                    return res.text()
                })
            };
            
            
            CalendarHelper._getMonth = async function(month, year){
                let url =  `'.$this->monthUpdate['url'].'?`;
                '.(isset($this->monthUpdate['data'])?'
                let data = '.json_encode($this->monthUpdate['data']):'
                let data = {};
                    ').'
                if(Object.keys(data).length){
                    for (let key in data){
                        url += key+`=`+ data[key]+`&`
                    }
                }
                return fetch(url+
                `&month=` + month +
                `&year=` + year)
                .then((res) => {
                    return res.json()
                })
            };
            
            CalendarHelper._getColor = function (date, dates = null) {
            if ('.$this->offDaysShow.')
                    if ([6, 0].includes(date.getDay()))
                        return `'.$this->colorClasses['offDay'].'`;
                        
                for (let i = 0; i<dates.length; i++){
                    if (dates[i] == DateHelper.dateToString(date)){
                        return `'.$this->colorClasses['accept'].'`
                    }
                }
                
                return `'.$this->colorClasses['default'].'`;
            }
            
            
            '.$this->script
        );
        $this->view->registerCss($this->css);
    }

}
?>

