<?php
/**
 * Custom Time Customizer Control
 * @author: Alex Standiford
 * @date  : 5/15/2017
 */

namespace esh\config;


function register_time_picker_control(){
  class timePicker extends \WP_Customize_Control{

    public function enqueue(){
      wp_enqueue_style('timepicki-style', ESH_ASSETS_URL.'timepicki/css/timepicki.css');
      wp_enqueue_style('customizer-fix', ESH_ASSETS_URL.'timepicker.css');
      wp_enqueue_script('timepicki-script', ESH_ASSETS_URL.'timepicki/js/timepicki.js', array('jquery'), false, true);
      wp_enqueue_script('timepicker-custom', ESH_ASSETS_URL.'timepicker.js', array('jquery'), false, true);
    }

    public function render_content(){ ?>
        <input type="text" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" data-customize-setting-link="<?php echo $this->id; ?>" readonly class="timepicker">

    <?php }

  }
}

add_action('customize_register', __NAMESPACE__.'\\register_time_picker_control');