<?php
/*
Plugin Name: Easy Store Hours Plugin
Description: Display Your Store Hours Quickly And Easily
Version: 1.0
Author: Alex Standiford
Author URI: http://www.fillyourtaproom.com
License: GPL2
*/

namespace esh;

use esh\config\customizer;

if(!defined('ABSPATH')) exit;

class esh{
  private static $instance = null;

  private $includes = array(
    'config/timePicker.php',        //Time Picker Customizer Field
    'config/customizer.php',        //Customizer Integration
    'config/option.php',            //Options Wrapper
    'app/day.php',                  //Grabs individual data for a given day
    'app/storeHourQuery.php',       //Grabs all of data for a given week
    'app/storeHours.php',           //Contains most functions that render the content
  );

  private $shortcodes = array(
    'esh_get_store_hours' => array('\esh\app\storeHours', 'getShortcode'),
  );

  private function __construct(){
  }


  /**
   * Fires up the plugin.
   * @return self
   */
  public static function getInstance(){
    if(!isset(self::$instance)){
      self::$instance = new self;
      self::$instance->_defineConstants();
      self::$instance->_includeFiles();
      self::$instance->_addShortcodes();
    }

    return self::$instance;
  }

  private function _addShortcodes(){
    foreach($this->shortcodes as $shortcode => $callback){
      add_shortcode($shortcode, $callback);
    }
  }

  /**
   * Defines the constants related to Social Media Crons
   * @return void
   */
  private function _defineConstants(){
    define('ESH_URL', plugin_dir_url(__FILE__));
    define('ESH_PATH', plugin_dir_path(__FILE__));
    define('ESH_ASSETS_URL', ESH_URL.'assets/');
    define('ESH_ASSETS_PATH', ESH_PATH.'assets/');
    define('ESH_TEXT_DOMAIN', 'socialmediacrons');
    define('ESH_PREFIX', 'esh');
  }

  /**
   * Grabs the files to include, and requires them
   * @return void
   */
  private function _includeFiles(){
    foreach($this->includes as $include){
      require_once(ESH_PATH.'lib/'.$include);
    }
  }
}

//Let's rock 'n roll
esh::getInstance();

/**
 * Initializes the customizer on the admin
 * @return void
 */
function customize_init(){
  customizer::register();
}

add_action('customize_register', __NAMESPACE__.'\\customize_init');