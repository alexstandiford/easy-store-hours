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
    if($this->openHour == false || $this->closedHour == false){
      $has_override = false;
    }
    else{
      $has_override = true;
    }

    return $has_override;
  }

  /**
   * Checks to see if the day is open
   * @return bool
   */
  public function isOpen(){
    $closed = option::get($this->day.'_is_closed');
    $is_open = $closed == 'closed' ? false : true;

    return $is_open;
  }

}