<?php
/**
 * Grabs all of the store hours based on specified args
 * @author: Alex Standiford
 * @date  : 5/15/2017
 */

namespace esh\app;


class storeHourQuery{

  public $args = array('days' => array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'),);
  public $days = null;
  
  public function __construct($args){
    $this->args = wp_parse_args($args, $this->args);
    $this->days = $this->getDays();
  }

  /**
   * Grab the next day's data, store it in the object, and shift that item off of the query array
   */
  public function theDay(){
    $this->day = $this->days[0];
    array_shift($this->days);
  }

  /**
   * Checks to see if there are any days left to display
   * @return bool
   */
  public function haveDays(){
    $day_count = count($this->days);
    $have_days = $day_count > 0 ? true : false;
    return $have_days;
  }

  /**
   * Loops through the days in the args and grabs the day objects
   * @return array
   */
  public function getDays(){
    $days = array();
    foreach($this->args['days'] as $day){
      $days[$day] = new day($day);
    }
    $this->days = $days;
    return $days;
  }

}