<?php
namespace backend\widgets;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@backend/widgets/Calendar/assets';
    public $baseUrl = '@web';
    public $css = ['css/style.css'];
    public $js = [
        'js/script.js',
        'js/src/CalendarHelper.js',
        'js/src/DateHelper.js'
        ];
}