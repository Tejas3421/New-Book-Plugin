<?php

/**
 * Class For Widget
 *
 * @link       
 * @since 1.0.0
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
        $category = apply_filters('widget_category', $instance['category']);

        echo $args['before_widget'];
        
        
        

        if(!empty($instance['category'])) {
            
            echo $args['before_title'].'Post from category '.$category . $args['after_title'];

        
            $args = array(
                'post_type' => 'book',
                'taxonomy'  => $category
                );

            $posts = new WP_Query($args);

            //checking that category has post or not
            if($posts->have_posts()) :

                //looping through posts
                while ($posts->have_posts()) : $posts->the_post();
                    //printing title of that book
                    echo the_title().'<br>';
                endwhile;
                
            endif;
            
        }



    }

    //widget setting
    function form($instance)
    {

        if(isset($instance['category'])) {
            $catagory= $instance['category'];  
        }
        else{
            $catagory = __('New Category');
        }

            //form tag for entering category for widget
        ?>
          <div>
                <label for='<?php echo $this->get_field_id('category') ?>'><?php _e("Category") ?></label>
                <input class='widefat' type='text' id='<?php echo $this->get_field_id('category') ?>' name='<?php echo $this->get_field_name('category') ?>' value="<?php echo esc_attr($catagory); ?>" >
            </div>
        <?php
    }

    //update instance
    public function update( $new_instance, $old_instance ) 
    {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

}

