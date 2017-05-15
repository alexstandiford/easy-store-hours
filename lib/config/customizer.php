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
  private $sections = [
    /*'social_media_integration' => [
      'title'       => 'Social Media Integrations',
      'description' => 'Integrate your social media accounts',
      'priority'    => 90,
      'capability'  => 'edit_theme_options',
    ],*/
  ];
  /**
   * Registers all settings fields and controls
   * @format 'setting_name' => ['arg' => 'value']
   * if a control_type value is set to a WP control, that control will be created instead of a simple field
   * @var array
   */
  private $settings = [
    /*'instagram_key'  => [
      'type'        => 'text',
      'label'       => 'Instagram Key',
      'description' => "Add your Instagram key here. Don't have one? <a href='http://services.chrisriversdesign.com/instagram-token' target='blank'>Get one here.</a>",
      'section'     => 'social_media_integration',
    ],*/
  ];
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
    self::$instance->getSections();
    self::$instance->getFields();
  }

  /**
   * Gets the customizer sections
   * @return void
   */
  private function getSections(){
    global $wp_customize;
    foreach($this->sections as $section => $values){
      $wp_customize->add_section('smc_'.$section, $values);
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
      $wp_customize->add_setting('smc_'.$setting, [
        'type'    => 'option',
        'default' => $value['default'],
      ]);
      if($value['control_type'] == null){
        $control_args = [
          'label'       => $value['label'],
          'type'        => $value['type'],
          'description' => $value['description'],
          'section'     => 'smc_'.$value['section'],
          'settings'    => 'smc_'.$setting,
        ];
        if($value['type'] == 'select'){
          $control_args['choices'] = $value['choices'];
        }
        $wp_customize->add_control('smc_'.$setting, $control_args);
      }
      else{
        $customizer = $value['control_type'];
        $wp_customize->add_control(new $customizer($wp_customize, 'logo', [
          'label'    => 'Upload your logo',
          'section'  => $value['section'],
          'settings' => 'smc_'.$setting,
        ]));
      }
    }
  }
}