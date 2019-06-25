<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 15.11.18
 * Time: 21:42
 */

namespace common\hhapi\core\lib;


use common\classes\Debug;
use common\hhapi\core\request\Request;

class Company
{
    use Request;

    public $company;
    public $jobs;
    public $id;

    public function __construct($id)
    {
        if ($id) {
            $this->id = $id;
            $company = $this->baseRequest('employers/' . $id)->get();
            $this->company = $company;
        }
    }

    public function getName()
    {
        return $this->company->name;
    }

    public function getDescription()
    {
        return $this->company->description;
    }

    public function getJobs()
    {
        $j = $this->baseRequest('vacancies')->addParams(['employer_id' => $this->id])->get();
        if($j){
            foreach ($j->items as $item){
                $this->jobs[] = new Vacancy($item);
            }
        }
        return $this->jobs;
    }

}