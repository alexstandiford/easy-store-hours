<?php
/**
 * $FILE_DESCRIPTION$
 * @author: Alex Standiford
 * @date  : 5/18/2017
 */

namespace esh\app;


class cssClassSet{

  public $classes = array();

  public function __construct($classes = array()){
    $this->classes = $this->filterClasses($classes);
  }

  public function filterClasses($classes){
    $result = array();
    foreach($classes as $class => $is_true){
      if($is_true){
        $result[] = $class;
      }
    }

    return $result;
  }

  /**
   * Gets the filtered class, and returns it as a chain of CSS classes for HTML markup
   * @return string
   */
  public function getFilteredClasses(){
    $classes = implode(' ', $this->classes);
    return "class='".$classes."'";
  }

  /**
   * Static wrapper for the getFilteredClasses method. This is just a shortcut to keep template files clean
   *
   * @param array $classes
   *
   * @return string
   */
  public static function build($classes = array()){
    $instance = new self($classes);

    return $instance->getFilteredClasses();
  }
}