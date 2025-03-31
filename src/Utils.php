<?php

namespace Koderpedia\LaravelBayarkan;

class Utils
{
  /**
   * Define str time to unix time
   * 
   * @param integer $duration Time duration
   * @param string  $unit time unit in second/minute/hour/day
   * 
   * @return integer
   */
  public static function unixTime(int $duration, string $unit): int
  {
    $time = 0;
    if ($unit == "second") {
      $time = time() + $duration;
    } else if ($unit == "minute") {
      $time = time() + $duration * 60;
    } else if ($unit == "hour") {
      $time = time() + $duration * 60 * 60;
    } else if ($unit == "day") {
      $time = time() + $duration * 24 * 60 * 60;
    }
    return $time;
  }
}
