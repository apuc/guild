<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 15.11.18
 * Time: 17:34
 */

require_once 'init.php';

$v = new \core\lib\Vacancy('28246746');
$c = new \core\lib\Company('2495437');

echo '<pre>';
print_r(\core\service\HHService::run()->company('2495437')->getJobs());
echo '</pre>';