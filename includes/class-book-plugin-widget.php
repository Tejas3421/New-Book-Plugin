<?php

/**
 * Class For Widget
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Book
 * @subpackage Book/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Book
 * @subpackage Book/includes
 * @author     Tejas Patle 
 */

class Book_Catagory_Widget extends WP_Widget 
{
    /**
     * constructor for widget class
     */
    public function __construct()
    {
        parent::__construct(
            'book_catagory_widget', "Book Catagory Widget", array('description'=> __("WIdget For displaying book of same catagory"))
        );
    }

    function widget($args, $instance)
    {
        $category = apply_filters('widget_title', $instance['category']);

        echo $args['before_widget'];

        $sql= 'SELECT * FROM wp_post WHERE category='.$category;        

        error_log(print_r($sql ,true));

        if(!empty($instance['category']))
        {
            
            echo $args['before_title'].'Post from category ' . $args['after_title'];
            $args = array(
                'category' => $category
            );
        
            
            $cats = get_post($args);

            while($cats->have_posts)
            {
                error_log(print_r("In post title fcuntion",true));
                echo '<ul>';
                echo '<li>'.$cats->post_title()."</li>";
                echo '</ul>';
            }
            
        }

    }

    //widget setting
    function form($instance)
    {

        if(isset($instance['category']))
        {
            $catagory= $instance['category'];  
        }
        else{
            $catagory = __('New Category');
        }

        ?>
          <div>
                <label for='<?php echo $this->get_field_id('category') ?>'><?php _e("Category") ?></label>
                <input class='widefat' type='text' id='<?php echo $this->get_field_id('category') ?>' name='<?php echo $this->get_field_name('category') ?>' value="<?php echo esc_attr($catagory); ?>" >
            </div>
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance=array();
        $instance['category'] =(!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : "" ; 
        return $instance; 
    }   

}

