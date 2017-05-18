<?php
/**
 * Handles template loading for the item display
 * @author: Alex Standiford
 * @date  : 5/18/2017
 */

namespace esh\app;


class template{

  public function __construct($template_name){
    $this->templateName = $this->templateWithExtension($template_name);
    $this->themeDir = apply_filters('esh_template_directory', get_stylesheet_directory().'store-hours');
    $this->overrideTemplate = $this->themeDir.$this->templateName;
    $this->defaultTemplate = ESH_TEMPLATE_DIRECTORY.$this->templateName;
  }

  /**
   * Returns the template name along with the extension. If the template already has an extension at the end, it will simply return the string as-is
   *
   * @param $template_name
   *
   * @return string
   */
  public function templateWithExtension($template_name){
    $has_extension = strpos($template_name, '.php');
    if($has_extension){
      $template = $template_name;
    }
    else{
      $template = $template_name.'.php';
    }

    return $template;
  }

  /**
   * Checks to see if a template has an override in the theme
   * @return bool
   */
  public function hasOverride(){
    return file_exists($this->overrideTemplate);
  }

  /**
   * Loads a template from a template name
   * @param $template_name
   *
   * @return string
   */
  public static function getFile($template_name){
    $template = new self($template_name);
    if($template->hasOverride()){
      $path = $template->overrideTemplate;
    }
    else{
      $path = $template->defaultTemplate;
    }
    return $path;
  }
}