<?php

/**
* Class for convenience methods
*/
class csToolkit
{
  /**
   * implode for an associative array
   * 
   *
   * @param string $array     - associative array to explode
   * @param string $template  - string template in which to implode the array.  use %key% and %value%
   * @param string $sep       - used to implode templates, empty by default
   * @return void
   * @author Brent Shaffer
   */
  static function assoc_implode($array, $template, $sep = '')
  {
   $ret = array();
   foreach ($array as $key => $value) 
   {
     $ret[] = strtr($template, array('%key%' => $key, '%value%' => $value));
   }
   return implode($sep, $ret);
  }

  static function truncate($text, $length = 30, $truncate_string = '...', $truncate_lastspace = false)
  {
    if ($text == '')
    {
      return '';
    }

    $mbstring = extension_loaded('mbstring');

    if ($mbstring)
    {
      @mb_internal_encoding(mb_detect_encoding($text));
    }

    $strlen = ($mbstring) ? 'mb_strlen' : 'strlen';
    $substr = ($mbstring) ? 'mb_substr' : 'substr';

    if ($strlen($text) > $length)
    {
      $truncate_text = $substr($text, 0, $length - $strlen($truncate_string));

      if ($truncate_lastspace)
      {
        $truncate_text = preg_replace('/\s+?(\S+)?$/', '', $truncate_text);
      }

      return $truncate_text.$truncate_string;
    }
    else
    {
      return $text;
    }
  }

  /**
   * Examples:
   * print(csToolkit::duration(time(), 6) . "n"); // 36 years 8 months 3 weeks 2 days 24 minutes 32 seconds
   * print(csToolkit::duration(time(), 4) . "n"); // 36 years 8 months 3 weeks 2 days
   * print(csToolkit::duration(time(), 2) . "n"); // 36 years 8 months
   *
   * @param string $seconds 
   * @param string $max_periods 
   * @return void
   * @author Brent Shaffer
   */
  static public function duration($seconds, $max_periods = 3)
  {
    $periods = array("year" => 31536000, "month" => 2419200, "week" => 604800, "day" => 86400, "hour" => 3600, "minute" => 60, "second" => 1);
    $i = 1;
    foreach ( $periods as $period => $period_seconds )
    {
        $period_duration = floor($seconds / $period_seconds);
        $seconds = $seconds % $period_seconds;
        if ( $period_duration == 0 )
        {
            continue;
        }
        $duration[] = "{$period_duration} {$period}" . ($period_duration > 1 ? 's' : '');
        $i++;
        if ( $i >  $max_periods )
        {
            break;
        }
    }
    return implode(' ', $duration);
  }
}

