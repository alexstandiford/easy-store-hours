<?php
/**
 * $FILE_DESCRIPTION$
 * @author: Alex Standiford
 * @date  : 5/15/2017
 */

namespace esh\config;


if(!defined('ABSPATH')) exit;

/**
 * Class option
 * Simple wrapper for get_option WordPress function. Added to a class for scalability purposes
 * @package eav\config
 */
class option{
  /**
   * Gets an option value for Easy Age Verifier
   *
   * @param $value
   *
   * @return mixed
   */
  public static function get($value){
    $option = get_option(ESH_PREFIX.'_'.$value);

    return $option;
  }

  /**
   * Gets the hour value of a specified day and type
   * @param $day: the day of the week to load
   * @param $type: should be either "open" or "closed"
   *
   * @return mixed
   */
  public static function getHourValue($day, $type){
    $day = strtolower($day);
    $option = self::get($day.'_'.$type.'_hour');

    return $option;
  }

  /**
   * Helper function for add_option. Adds the prefix to the option value
   *
   * @param        $option
   * @param string $value
   * @param string $autoload
   *
   * @return bool
   */
  public static function add($option, $value = '', $autoload = 'yes'){
    $result = add_option(ESH_PREFIX.'_'.$option, $value, '', $autoload);

    return $result;
  }

}