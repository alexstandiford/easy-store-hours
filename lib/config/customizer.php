<?php
/**
 * Customizer settings
 * @author: Alex Standiford
 * @date  : 2/7/2017
 */

namespace esh\config;

class customizer{
  /**
   * Registers all sections.
   * @format 'section_name' => ['arg' => 'value']
   * @var array
   */
  private $sections = array(
    'store_hours' => array(
      'title'       => 'Store Hours',
      'description' => 'Specify your store hours',
      'priority'    => 70,
      'capability'  => 'manage_options',
    ),
  );
  /**
   * Registers all settings fields and controls
   * @format 'setting_name' => ['arg' => 'value']
   * if a control_type value is set to a WP control, that control will be created instead of a simple field
   * @var array
   */
  private $settings = array();
  /**
   * The singleton instance of the customizer
   * @var null
   */
  private static $instance = null;

  /**
   * Private customizer. Keeps people from indirectly screwing with this class
   * customizer constructor.
   */
  private function __construct(){
  }

  /**
   * Generates the customizer singleton instance
   * @return void
   */
  public static function register(){
    self::$instance = new self;
    self::$instance->combineSettings();
    self::$instance->getSections();
    self::$instance->getFields();
  }

  private function combineSettings(){
    $days = array('default', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday',);
    foreach($days as $day){
      $this->settings[$day.'_open_hour'] = array(
        'control_type' => 'esh\config\timePicker',
        'label'        => 'Open Time',
        'section'      => 'store_hours',
        'day'          => $day,
        'transport'    => 'refresh',
      );
      $this->settings[$day.'_closed_hour'] = array(
        'control_type' => 'esh\config\timePicker',
        'label'        => 'Closing Time',
        'section'      => 'store_hours',
        'transport'    => 'refresh',
      );
      $this->settings[$day.'_is_closed'] = array(
        'type'    => 'checkbox',
        'label'   => 'Closed',
        'section' => 'store_hours',
      );

    }
  }

  /**
   * Gets the customizer sections
   * @return void
   */
  private function getSections(){
    global $wp_customize;
    foreach($this->sections as $section => $values){
      $wp_customize->add_section('esh_'.$section, $values);
    }
  }

  /**
   * Gets the basic fields for the customizer
   * Extra basic fields can be added via `eav_customizer_settings`, but support is limited to basic fields that require no controller
   * @return void
   */
  private function getFields(){
    global $wp_customize;
    foreach($this->settings as $setting => $value){
      $wp_customize->add_setting('esh_'.$setting, array(
        'type'    => 'option',
        'default' => $value['default'],
      ));
      if($value['control_type'] == null){
        $control_args = array(
          'label'       => $value['label'],
          'type'        => $value['type'],
          'description' => $value['description'],
          'section'     => 'esh_'.$value['section'],
          'settings'    => 'esh_'.$setting,
        );
        if($value['type'] == 'select'){
          $control_args['choices'] = $value['choices'];
        }
        $wp_customize->add_control('esh_'.$setting, $control_args);
      }
      else{
        $customizer = $value['control_type'];
        $wp_customize->add_control(new $customizer($wp_customize, 'esh_'.$setting, array(
          'label'       => $value['label'],
          'description' => $value['description'],
          'section'     => 'esh_'.$value['section'],
          'settings'    => 'esh_'.$setting,
          'day'         => isset($value['day']) == true ? ucfirst($value['day']) : false,
        )));
      }
    }
  }
}