<?php
/**
 * Helper class to make generating store hours easier
 * @author: Alex Standiford
 * @date  : 5/16/2017
 */

namespace esh\app;

class storeHours{

  public function __construct($args = array()){
    $this->query = new storeHourQuery($args);
  }

  public static function getShortcode(){
    $result = '';
    $store_hours = new self();
    foreach($store_hours->query->days as $day){
      $result .= ucfirst($day->day);
      $result .= ": ";
      if($day->isOpen()){
        $result .= $day->openHour;
        $result .= " - ";
        $result .= $day->closedHour;
      }
      else{
        $result .= "Closed";
      }
      $result .= "<br>";
    }

    return $result;
  }

}