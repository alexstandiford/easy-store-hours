<?php
/**
 * Uninstallation script file. Runs when Easy Age Verifier is deleted
 */
if(!defined('WP_UNINSTALL_PLUGIN')){
  die;
}
$days = array(
  'sunday',
  'monday',
  'tuesday',
  'wednesday',
  'thursday',
  'friday',
  'saturday',
);
$options = array(
  'open_hour',
  'closed_hour',
  'is_closed',
);
$is_multisite = is_multisite();
foreach($days as $day){
  foreach($options as $option){
    if($day != 'default' && $option != 'is_closed'){
      $option = ESH_PREFIX.'_'.$option;
      delete_option($option);
      if($is_multisite){
        delete_site_option($option);
      }
    }
  }
}