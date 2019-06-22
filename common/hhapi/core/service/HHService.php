<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 15.11.18
 * Time: 22:24
 */

namespace common\hhapi\core\service;


use common\hhapi\core\lib\Company;
use common\hhapi\core\lib\Vacancy;

class HHService
{

    /**
     * @param $id
     * @return Company
     */
    public function company($id)
    {
        return new Company($id);
    }

    /**
     * @param $id
     * @return Vacancy
     */
    public function vacancy($id)
    {
        return new Vacancy($id);
    }

    /**
     * @return HHService
     */
    public static function run()
    {
        return new self();
    }

}