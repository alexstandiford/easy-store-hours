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

  public function getTime($type,$day = false){
    if(!$day){
      $day = $this->day;
    }
    $hour = option::getHourValue($day, $type) == false ? option::getHourValue('default', $type) : option::getHourValue($day, $type);
    $time = date($this->dateFormat,strtotime($hour));
    return $time;
  }

  /**
   * Checks to see if the day has any custom overrides
   * @return bool
   */
  public function hasOverride(){
    $is_open_hour_overridden = $this->openHour != $this->getTime('open','default');
    $is_closed_hour_overridden = $this->closedHour != $this->getTime('closed','default');
    if($is_open_hour_overridden || $is_closed_hour_overridden || $this->isClosed()){
      $has_override = true;
    }
    else{
      $has_override = false;
    }
    return $has_override;
  }

  /**
   * Checks to see if the day is open
   * @return bool
   */
  public function isOpen($day = false){
    if(!$day){
      $day = $this->day;
    }
    $closed = option::get($day.'_is_closed');
    $is_open = $closed == 'closed' ? false : true;

    return $is_open;
  }

  /**
   * Checks to see if the day is closed
   * @return bool
   */
  public function isClosed(){
    return !$this->isOpen();
  }


}