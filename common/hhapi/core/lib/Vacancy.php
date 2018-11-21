<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 15.11.18
 * Time: 21:16
 */

namespace common\hhapi\core\lib;


use common\hhapi\core\request\Request;

class Vacancy
{
    use Request;

    public $item;

    public function __construct($data = null)
    {
        if (is_string($data) || is_integer($data)) {
            $item = $this->baseRequest('vacancies/' . $data)->get();
            $this->item = $item;
        }
        else {
            $this->item = $data;
        }
    }

    public function getName()
    {
        return ($this->item) ? $this->item->name : null;
    }

    public static function search($params)
    {
        $v = new self();
        return $v->baseRequest('vacancies')->addParams($params)->get();
    }



}