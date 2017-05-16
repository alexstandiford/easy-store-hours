<?php
/**
 * A single store hours day
 * @author: Alex Standiford
 * @date  : 5/15/2017
 */

namespace esh\app;

use esh\config\option;

class day{

  public $day = false;

  public function __construct($day){
    $this->day = strtolower($day);
    if($this->isOpen()){
      $this->openHour = option::get($this->day.'_open_hour') == false ? option::get('default_open_hour') : option::get($this->day.'_open_hour');
      $this->closedHour = option::get($this->day.'_closed_hour') == false ? option::get('default_closed_hour') : option::get($this->day.'_closed_hour');
    }
    else{
      $this->openHour = 'closed';
      $this->closedHour = 'closed';
    }
  }

  /**
   * Checks to see if the day has any custom overrides
   * @return bool
   */
  public function hasOverride(){
    $overrides = option::get('day_overrides');
    $has_override = $overrides[$this->day] == true ? true : false;
    return $has_override;
  }

  /**
   * Checks to see if the day is closed
   * @return bool
   */
  public function isClosed(){
    $closed = option::get($this->day.'_is_closed');
    $is_closed = $closed == 'closed' ? true : false;
    return $is_closed;
  }

  /**
   * Gets the hours of the given day.
   * @return array|string
   */
  public function getHours(){
    //Check to see if there is an override on hours for the day. If there isn't, just get the default
    if($this->hasOverride()){
      //Check to see if the store is closed that day. If it isn't, get the hours
      $hours = $this->isClosed() == true ? 'closed' : option::get($this->day.'_hours');
    }
    else{
      $hours = option::get('default_hours');
    }
    return $hours;
  }

}