<?php
/**
 * $FILE_DESCRIPTION$
 * @author: Alex Standiford
 * @date  : 5/18/2017
 */

namespace esh\app;

use esh\app\storeHours;

class widget extends \WP_Widget{

  public function __construct(){
    $args = array(
      'description' => 'Display Your Store Hours',
    );
    parent::__construct('esh_store_hours', 'Store Hours', $args);
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance){
    echo $args['before_widget'];
    if(!empty($instance['title'])){
      echo $args['before_title'].apply_filters('widget_title', $instance['title']).$args['after_title'];
    }
    echo storeHours::getWidget();
    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form($instance){
    $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'text_domain');
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>
    <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update($new_instance, $old_instance){
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

    return $instance;
  }
}