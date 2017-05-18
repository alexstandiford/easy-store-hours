<?php
/**
 * Helper class to make generating store hours easier
 * @author: Alex Standiford
 * @date  : 5/16/2017
 */

namespace esh\app;

class storeHours{

  public $currentDay = null;

  public function __construct($args = array()){
    $this->query = new storeHourQuery($args);
    $this->hourSeparator = $this->validateValue($args['separator'], apply_filters('esh_separator', ' - '));
    $this->beforeHour = $this->validateValue($args['before_hour'], apply_filters('esh_before_hour', ''));
    $this->afterHour = $this->validateValue($args['after_hour'], apply_filters('esh_after_hour', ''));
    $this->closedText = $this->validateValue($args['closed_text'], apply_filters('esh_closed_text', 'Closed'));
    $this->ranAsShortcode = $args['ran_as_shortcode'] ? true : false;
    $this->ranAsWidget = $args['ran_as_widget'] ? true : false;
  }

  private static function validateValue($value_if_true, $value_if_false){
    return is_string($value_if_true) ? $value_if_true : $value_if_false;
  }

  public static function get($args){
    $store_hours = new self($args);
    ob_start();
    include(template::getFile('header'));
    foreach($store_hours->query->days as $day){
      $store_hours->currentDay = $day;
      include(template::getFile('single_item'));
    }
    include(template::getFile('footer'));
    $result = ob_get_clean();

    return $result;
  }

  public static function getShortcode($args = array()){
    $args['ran_as_shortcode'] = true;
    return self::get($args);
  }

  public static function getWidget($args = array()){
    $args['ran_as_widget'] = true;
    return self::get($args);
  }

  /**
   * Gets the opening and closing hours of a specified day. Returns a formatted date
   *
   * @param bool $day
   * @param bool $separator
   * @param bool $before
   * @param bool $after
   * @param bool $closed_text
   *
   * @return string
   */
  public function getHours($day = false, $separator = false, $before = false, $after = false, $closed_text = false){
    $separator = $this->validateValue($separator, $this->hourSeparator);
    $before = $this->validateValue($before, $this->beforeHour);
    $after = $this->validateValue($after, $this->afterHour);
    $day = is_object($day) ? $day : $this->currentDay;
    if($day->isOpen()){
      $hours = $before.$day->openHour.$separator.$day->closedHour.$after;
    }
    else{
      $hours = $this->validateValue($closed_text, $this->closedText);
    }

    return $hours;
  }

  /**
   * Generates the class for a single store hour item
   */
  public function singleClass($extra_classes = array()){
    $current_day = $this->currentDay->day;
    $default_classes = apply_filters('esh_single_item_classes', array(
      'weekend'           => $current_day == "saturday" || $current_day == "sunday",
      'weekday'           => $current_day != "saturday" && $current_day != "sunday",
      'day-'.$current_day => isset($this->currentDay),
      'is-closed'         => $this->currentDay->isClosed(),
      'abnormal-day'      => $this->currentDay->hasOverride(),
      'normal-day'        => !$this->currentDay->hasOverride(),
    ));
    $args = array_merge($default_classes, $extra_classes);
    $classes = new cssClassSet($args);

    return $classes->getFilteredClasses();
  }

  /**
   * Generates the class for a single store hour item
   */
  public function wrapperClass($extra_classes = array()){
    $default_classes = apply_filters('esh_wrapper_classes', array(
      'store-hours-wrapper'     => true,
      'store-hours-shortcode-item' => $this->ranAsShortcode,
      'store-hours-widget-item' => $this->ranAsWidget,
    ));
    $args = array_merge($default_classes, $extra_classes);
    $classes = new cssClassSet($args);

    return $classes->getFilteredClasses();
  }

}