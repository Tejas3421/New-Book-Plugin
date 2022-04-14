<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link  http://localhost/WordPress/
 * @since 1.0.0
 *
 * @package    Book_Plugin
 * @subpackage Book_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Book_Plugin
 * @subpackage Book_Plugin/admin
 * @author     Tejas Patle <tejas.patle@hbwsl.com>
 */
class Book_Plugin_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Book_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Book_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/book-plugin-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Book_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Book_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/book-plugin-admin.js', array( 'jquery' ), $this->version, false);

    }

    // My Admin Functions Starts Here

    public function Register_Custom_Post_Type_books()
    { 
        
        //error_log(print_r('functioncalled',true));
        $labels= array(
        'name'=>'Books',
        'singular-name'=>'Book'
        );
        
        $supports= array('title','editor','thumbnail','comments','excerpts');  //array of element support by our post type
            
        $options = array(
        'labels' => $labels,
        'public'=> true,
        'rewrite'=>array('slug'=>'book'),
        'supports'=>$supports,
        'taxonomies'=> array('book-catagory','book-tag')
        );


        //registering custom post type
        register_post_type("book", $options);  

    } 
    
    /**
     *  Created custom hierarchical taxonomy 
     * **/
    public function Register_Custom_Hierarchical_Taxonomy_Book_catagery()
    {

        $labels=array(
        'name'=>'Books Catagories',
        'singular-name'=>'Book Catagory'
        );
        
        $options = array(
        'labels' => $labels,
        'hierarchical'=> true,
        'rewrite'=> array('slug' => 'book-catagory'),
        'show_admin_column'=>false
        );


        //register catagory for Book post type

        register_taxonomy('book-catagory', array('book'), $options); 
    }
    
    

    /**
     * Cretaing non hierarchical taxonomy 
     *
     * @return void
     */
    public function Register_Non_Hierarchical_Taxonomy_Book_tag()
    {

        $labels = array(
        'name' => 'Book Tags',
        'singular_name' =>  'Book Tag',
        'parent_item' => null,
        'parent_item_colon' => null,
        'public'=> true
        ); 

        $options=array(
        'hierarchical' => false, 
        'labels' => $labels,
        'show_in_rest' => true,
        'show_admin_column' => false,
        'rewrite' => array( 'slug' => 'book-tag' ) 
        );

        register_taxonomy('book-tag', 'book', $options); //registering taxonomy for book tag
    }   

    

    /**
     * Adding a MEnu Page for Book
     *
     * @return void
     */
    public function Add_Menu_Page_book()
    {
        //added submenu section Book setting inn Book POst Type
        add_submenu_page(
            'edit.php?post_type=book', //$parent_slug
            'Book Settings Page',  //$page_title
            'Book Settings',        //$menu_title
            'manage_options',           //$capability
            'book_Settings-page', //menu slug
            [self::class, 'Book_Setting_Page_book'] //$function
        );

    }

        
    /**
     * Creating settings page for book
     *
     * @return void
     */
    Public static function Book_Setting_Page_book()
    {


        //check for currency and no of post per page is given or not
        if(isset($_POST['currency']) && isset($_POST['no_of_post'])) { 
            
            //saving entered data in variable
            $currency=$_POST['currency'];           
            $no_of_post=$_POST['no_of_post'];       

            update_option('book_currency', $currency);       //update currency option
            update_option('book_no_of_post', $no_of_post);		//update no of post options
        }
        
        //getting previous option 
        $options = get_option('book_currency'); 

        echo '<script>console.log("'.$options.'")</script>';
        
        ?>

            <!--This is form for admin book setting menu page to select currency and no of post per page--->
            <h1>Book Setting Page</h1>
            <form method="post">
            <label for="currency">Currency</label>
            <select id="currency" name="currency">
              <option value="₹" <?php selected($options, '₹'); ?>>₹</option>
              <option value="$" <?php selected($options, '$'); ?>>$</option>
              <option value="€" <?php selected($options, '€'); ?>>€</option>
            </select>
            <br><br>
            
            <label for="no_of_post">No of post per page</label>
            
                <input type="number" id="no_of_post" placeholder="Eg. 4 or 5" name="no_of_post"><br/><br/>
                <input type="submit" class="button-primary" value="<?php _e('Save changes', 'bookdomain'); ?>" />
            </form>
                
        <?php
  
        
    }




    /**
     * Function to diaplaying bbok details
     **/


    /**
     * Creating a shortcode
     */
    public function Shortcode_book(  $atts=[] , $content = null , $tag = '')
    {
        //global $wpdb

        


        
        /*if ($atts) {
            foreach ($atts as $key => $a) {
                // 

                $args=array(
                    'post_type'=>'book',
                    'meta_query'=> array(
                        array(
                        'key'=> $key,
                        'value'=> $a
                        ),
                    )
                );
    
                $query = new WP_Query($args);

                //echo '<script>console.log("'.'")</script>';

                foreach ($query as $d) {
                    if ($d->$key == $a) {
                        array_push($newdata, $d);
                    }
                }

                // foreach($data as $d){

                // }
            }
            $data = $newdata;
        } */

        
        if ($atts) {

            foreach($atts as $key => $a) { //getting key from user

                //creating filter for 
                
                echo '<script>console.log("'.$key."   " .$a .'")</script>';  

                echo get_metadata('book',6,$key);
                
            }
           
            
        } 



        /*if ( $query->posts ) {

			foreach ( $query->posts as $key => $post_id ) {
				// var_dump( $post_id );
                echo '<script>console.log("HInd'.$post_id.'")</script>';
				// Code goes here..
			}
		}*/

        echo '<script>console.log("'.get_metadata().'")</script>';

        while ( $query->have_posts() ) : 
            $query->the_post();
            echo '<script>console.log("'." HIii".get_the_id().'")</script>';
            //echo  the_field('author_name'). " (" ;
            //echo  the_field('book_year'). ") ";
            //echo  the_field('book_publisher'). ". ";
            echo '<b>' . the_title() . '</b>'. ", ";
            //echo '<p></p>';

        endwhile;


        $content = '<div><p>HIuoidasnc</p>';
        /*foreach ($newdata as $row) {

            //printing information for book shortcode
            $c.= '<div style="border: 1px solid green;">
			<p style="text-align:center;">Book Details</p>
			<p style="text-align:center;">ID of Book '.$row->post_id.'</p>
			<p style="text-align:center;">Author of Book '.$row->author.'</p>
			<p style="text-align:center;">Price of Book '.$row->price.'</p>
			<p style="text-align:center;">Publisher Of Book '.$row->publisher.'</p>
			<p style="text-align:center;">pulished year '.$row->year.'</p>
			<p style="text-align:center;">edition of book '.$row->edition.'</p>
			</div><br/>';
        }*/
        $content .= '</div>';
        
        return $content; //returning content

    }

    public function shortcode_adding_fucntion()
    {

        //added shortcode "Book"
        add_shortcode('Book', [$this, 'New_Shortcode_book']);
    }


    public function New_Shortcode_book( $atts=[] , $content = null , $tag = '')
    {
        
        foreach($atts as $key => $a)
        {
            $get_all_post=get_posts(
                array( 
                'post_type' =>'book',
                'meta_key' => $key,
                'meta_value'=> $a
                )
            );

            foreach($get_all_post as $index=>$post)
            {
                echo '<script>console.log("'." HIii".$post->ID.'")</script>';;
            }

        }


    }


    /**
     * Creating  Meta Box For Books
     *
     * @return void
     */
    public function Add_Book_Meta_box() 
    {
        //added meta box in book post type
        add_meta_box("book-meta-box", 'Book Meta Box', [self::class, 'Book_Meta_fields'], 'book'); //adding meta box for book meta data
    }


    /**
     * Creating fields for Book 
     */
    
    public static function Book_Meta_fields() 
    {

        //creating field for input meta data for book post type
        ?>
        <label for="author">Enter Book Author</label>
        <input type="text" placeholder="Enter author name   " id="author" name="author_name" ><br/><br/>
        
        <label for="book_price">Enter Book Price</label>
        <input type="number" placeholder="Book Price" id="book_price" name="book_price"); ><br/><br/>
        
        <label for="book_publisher">Enter Book Publisher</label>
        <input type="text" placeholder="Book Publisher" id="book_publisher" name="book_publisher"><br/><br/>
        
        <label for="book_year">Book Year</label>
        <input type="number" placeholder="Book Year" id="book_year" name="book_year" ><br/><br/>
        
        <label for="book_edition">Book Edition</label>
        <input type="text" placeholder="Book Edition" id="book_edition" name="book_edition" ><br/><br/>
        <?php

    }

    


    //register metadata table with post type
	



	function add_myplugin_product_meta($post_id ) 
    {
        
        //updating author name in  book meta table
        if(isset($_POST['author_name']))
        {
            update_metadata('book', $post_id ,'author_name' , $_POST['author_name'] ); 
        }

        //updating value of price in book meta table
        if(isset($_POST['book_price']))
        {
            update_metadata('book', $post_id ,'book_price' , $_POST['book_price'] ); 
        }
        
        //updating value of publisher in meta table
        if(isset($_POST['book_publisher']))
        {
            update_metadata('book', $post_id ,'book_publisher' , $_POST['book_publisher'] ); 
        }

        //updating value of year in book meta table
        if(isset($_POST['book_year']))
        {
            update_metadata('book', $post_id ,'book_year' , $_POST['book_year'] ); 
        }

        //updating value of edition in book meta table
        if(isset($_POST['book_edition']))
        {
            update_metadata('book', $post_id ,'book_edition' , $_POST['book_edition'] ); 
        }
    }



    public function create_custom_gutenburg_block()
    {
        
    }

    public function book_admin_dashboard_widget()
    {

        // add dashboard widget in admin dashboard

        wp_add_dashboard_widget( 
            'book_admin_dashboard_widget',
            'book_admin_dashboard_widget Title',
            [self::class, 'book_admin_dashboard_widget_callback']
        );
    }

    public static function book_admin_dashboard_widget_callback()
    {

        // Output of dashboard widget to get 5 catagories

        echo '<h2>This is my admin widget to get top 5 catagories</h2>';
        $args = array(
        "taxonomy"  => "book-catagory", 
        "orderby"   => "count",
        "order"     => "DESC"
        );
 
        //getting catagories based on filter above
        $cats = get_categories($args);
        $count = 0;

        //looping through catagories
        foreach($cats as $cat) {
            if ($count == 5 ) {

                //break after 5 top catagories
                break;
            } else {

                //display catagory name and its count.
                echo '<p style="color:red;">'.$cat->name ." " .$cat->count."</p>" ;
                $count++;
            }
             
 
        }
    }

    public function Register_metatable()
    {
        global $wpdb;
        $wpdb->bookmeta = $wpdb->prefix.'bookmeta';
        $wpdb->tables[]='bookmeta';
    }
    
}
