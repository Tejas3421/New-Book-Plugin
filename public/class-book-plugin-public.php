<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://localhost/WordPress/
 * @since      1.0.0
 *
 * @package    Book_Plugin
 * @subpackage Book_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Book_Plugin
 * @subpackage Book_Plugin/public
 * @author     Tejas Patle <tejas.patle@hbwsl.com>
 */
class Book_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/book-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-plugin-public.js', array( 'jquery' ), $this->version, false );

	}

	
	

	
	

	public function book_admin_dashboard_widget()
	{
		global $wp_meta_boxes;
		wp_add_dashboard_widget( 
			'book_admin_dashboard_widget',
			'book_admin_dashboard_widget Title',
			[self::class, 'book_admin_dashboard_widget_callback']
		);
	}

	public static function book_admin_dashboard_widget_callback()
	{
		echo '<h2>This is my admin widget to get top 5 catagories</h2>';
		$args = array(
			"taxonomy"  => "book-catagory", 
			"orderby"   => "count",
			"order"     => "DESC"
		);


		$cats = get_categories($args);
		$count = 0;
		foreach($cats as $cat) {
			if ($count == 5 ) {
				break;
			} else {
				echo '<p style="color:red;">'.$cat->name ." " .$cat->count."</p>" ;
				$count++;
			}
			

		}
	}

	function Create_Book_Catagory_widget() 
	{
		register_widget('Book_Catagory_Widget');
	}

}
