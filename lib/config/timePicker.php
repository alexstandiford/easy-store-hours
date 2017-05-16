<?php
/**
 * Custom Time Customizer Control
 * @author: Alex Standiford
 * @date  : 5/15/2017
 */

namespace esh\config;


function register_time_picker_control(){
  class timePicker extends \WP_Customize_Control{

    public $day = null;

    public function enqueue(){
      wp_enqueue_style('timepicki-style', ESH_ASSETS_URL.'timepicki/css/timepicki.css');
      wp_enqueue_style('customizer-fix', ESH_ASSETS_URL.'timepicker.css');
      wp_enqueue_script('timepicki-script', ESH_ASSETS_URL.'timepicki/js/timepicki.js', array('jquery'), false, true);
      wp_enqueue_script('timepicker-custom', ESH_ASSETS_URL.'timepicker.js', array('jquery'), false, true);
    }

    public function render(){
      $id = 'customize-control-'.str_replace(array('[', ']'), array('-', ''), $this->id);
      $class = 'customize-control customize-control-'.$this->type;
      if($this->day):?>
        <h2 class="heading-<?php echo strtolower($this->day); ?>"><?php echo $this->day ?></h2>
        <?php if($this->day != 'Default'): ?>
          <button id="<?php echo $this->day; ?>" class="button button-secondary">Clear Overrides (Use Default)</button>
          <?php else: ?>
          <h3>If no value is set on a day, this set of time will be used.</h3>
          <?php endif; ?>
      <?php endif; ?>
      <li id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class); ?>">
        <label>
          <input type="text" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>_open" value="<?php echo $this->value(); ?>" data-customize-setting-link="<?php echo $this->id; ?>" readonly class="timepicker">
          <?php echo $this->label; ?>
        </label>
      </li>
    <?php }

  }
}

add_action('customize_register', __NAMESPACE__.'\\register_time_picker_control');