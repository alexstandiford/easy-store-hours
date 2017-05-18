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
    $this->name = ucfirst($this->day);
    $this->dateFormat = option::get('date_format') == false ? "g:i A" : option::get('date_format');
    if($this->isOpen()){
      $this->openHour = $this->getTime('open');
      $this->closedHour = $this->getTime('closed');
    }
    else{
      $this->openHour = 'closed';
      $this->closedHour = 'closed';
    }
  }

  public function getTime($type){
    $hour = option::getHourValue($this->day, $type) == false ? option::getHourValue('default', $type) : option::getHourValue($this->day, $type);
    $time = date($this->dateFormat,strtotime($hour));
    return $time;
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