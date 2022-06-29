<?php


namespace App\Libs;


class UtilsFunctions
{
    public function TimeFromString($date, $format = null )
    {
       return date($format ?? 'Y-m-d', strtotime($date));
    }
    public function dateFormString($date)
    {
      return date('Y-m-d', strtotime(strtr($date, '/', '-')));
    }
}
