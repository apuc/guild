<?php

namespace backend\modules\reports\models;

class Month
{

    public $inactive_begin;
    public $inactive_end;
    public $active;
    public $days;

    public function __construct($date = null)
    {
        $this->inactive_begin = [];
        $this->inactive_end = [];
        if ( !($date and self::is_date($date)) ){
            $date = date('Y-m-d');
        }
        $first_day_of_week = self::get_day_week(self::get_first_day($date));
        $quantity_days = self::get_days_month($date);

        $day = 1;

        for (
            $index = $first_day_of_week;
            $index < $first_day_of_week + $quantity_days;
            $index++, $day++
        ) {
            $this->active[$index] = $day;
        }

        $prev_month = date('Y-m-d', strtotime(self::get_first_day($date)) - 3600 * 37);

        $day = self::get_days_month($prev_month);

        for ($index = $first_day_of_week - 1; $index >= 1; $index--, $day--) {
            $this->inactive_begin[$index] = $day;
        }
        $day = 1;
        $index_end = (in_array($first_day_of_week, [6,7])?42:35);
        for ($index = $quantity_days + $first_day_of_week; $index <=$index_end; $index++, $day++) {
            $this->inactive_end[$index] = $day;
        }

        $this->days = array_merge($this->inactive_end, $this->inactive_begin, $this->active);

    }

    public static function next_day($date, $number)
    {
        return date('Y-m-d', strtotime($date) + 3600 * 24 * $number);
    }

    public static function get_first_day($date)
    {
        return date('Y-m-01', strtotime($date));
    }

    public static function get_day_week($date)
    {
        $day = date('w', strtotime(date($date)));
        if($day==0)
            return 7;
        return $day;
    }

    public static function is_date($date)
    {
        $date = date_parse($date);
        if ($date or checkdate($date['month'], $date['day'], $date['year']))
            return true;
        return false;
    }


    public static function get_days_month($date)
    {
        return date("t", strtotime($date));
    }

}