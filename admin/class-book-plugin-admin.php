<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://localhost/WordPress/
 * @since      1.0.0
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
class Book_Plugin_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/book-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

	// My Admin Functions Starts Here

	public function Register_Custom_Post_Type_books()
	{
		$labels= array(
			'name'=>'Books',
			'singular-name'=>'Book'
		);
		
		$supports= array('title','editor','thumbnail','comments','excerpts');
			
		$options = array(
			'labels' => $labels,
			'public'=> true,
			'rewrite'=>array('slug'=>'book'),
			'supports'=>$supports,
			'taxonomies'=> array('book-catagory','book-tag')
		);

		register_post_type( "Book", $options);
	}
	
	/**
	 *  Created custom hierarchical taxonomy 
	 * **/
	public function Register_Custom_Hierarchical_Taxonomy_Book_catagery() {

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
		
		register_taxonomy('book-catagory', array('book'), $options);
	}
	
	

	/**
	 * Cretaing non hierarchical taxonomy 
	 *
	 * @return void
	 */
	public function Register_Non_Hierarchical_Taxonomy_Book_tag() {

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

		register_taxonomy('book-tag', 'book', $options);
	}   

	

	/**
	 * Adding a MEnu Page for Book
	 *
	 * @return void
	 */
	public function Add_Menu_Page_book()
	{
	//  add_menu_page('Books Setting', 'Books Setting', 'manage_options', 'book-setting-page', 'Book_Setting_Page_book');

		//add_submenu_page('books', 'Books Setting', 'Books Setting', 'manage_options', 'book-setting-page', 'Book_Setting_Page_book');
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

		if(isset($_POST['currency']) && isset($_POST['no_of_post']))
		{
			$currency=$_POST['currency'];
			$no_of_post=$_POST['no_of_post'];

			update_option('book_currency', $currency);
			update_option('book_no_of_post', $no_of_post);
		}
		?>

		<h2>
			Hii This is Book Setting Page
		</h2>
		<h4>Here you can set your currency no of post per page</h4>
		<form method=post>
			<div id='currency-container'>
				<label for="currency">Currency</label>
				<select id="currency" name="currency">
					<option value="₹" <?php selected($options, '₹'); ?>>₹</option>
					<option value="$" <?php selected($options, '$'); ?>>$</option>
					<option value="€" <?php selected($options, '€'); ?>>€</option>
				</select>
			</div><br><br>
			<div id='no_of_post'>
				<label>No of Post Per page</label>
				<input type='number' id='no_of_post'><br><br>
			</div><br>
			<input type="submit" class="button-primary" value='<?php _e('Save changes'); ?>' />
		<form>

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
		global $wpdb;
        $query = 'SELECT * FROM `wp_metabox`';
        $data = $wpdb->get_results($query);
        $newdata = [];
		
        if ($atts){
            foreach($atts as $key => $a) {
				
                echo '<script>console.log("'.$a.'")</script>';
                foreach ($data as $d)
				{
					echo '<script>console.log("'.$d->$key.'")</script>';
					
                    if($d->$key == $a)
					{
                        array_push($newdata, $d);
                    }
                }
            }
            $data = $newdata;
        } 

        $c = '<div><p></p>';
        foreach ($data as $row) {
            $c.= '<div style="border: 1px solid green;">
			<p style="text-align:center;">Book Details</p>
			<p style="text-align:center;">ID of Book '.$row->post_id.'</p>
			<p style="text-align:center;">Author of Book'.$row->author.'</p>
			<p style="text-align:center;">Price of Book'.$row->price.'</p>
			<p style="text-align:center;">Publisher Of Book'.$row->publisher.'</p>
			<p style="text-align:center;">pulished year'.$row->year.'</p>
			<p style="text-align:center;">edition of book'.$row->edition.'</p>
			</div><br/>';
        }
        $c .= '</div>';

        return $c;

	}

	public function shortcode_adding_fucntion()
	{
		add_shortcode('Book', [$this, 'Shortcode_book']);    
	}
	/**
	 * register widget
	 */


	 /**
	 * Creating  Meta Box For Books
	 *
	 * @return void
	 */
	public function Add_Book_Meta_box() 
	{
		add_meta_box("book-meta-box", 'Book Meta Box', [self::class, 'Book_Meta_fields'], 'book');
	}

	/**
	 * Creating fields for Book 
	 */
	
	public static function Book_Meta_fields() 
	{
		?>
		<label for="author">Enter Book Author</label>&nbsp;&nbsp;&nbsp;
        <input type="text" placeholder="Book Author" id="author" name="author_name" ><br/><br/>
        <label for="book_price">Enter Book Price</label>&nbsp;&nbsp;&nbsp;
        <input type="number" placeholder="Book Price" id="book_price" name="book_price" ><br/><br/>
        <label for="book_publisher">Enter Book Publisher</label>&nbsp;&nbsp;&nbsp;
        <input type="text" placeholder="Book Publisher" id="book_publisher" name="book_publisher"><br/><br/>
        <label for="book_year">Book Year</label>&nbsp;&nbsp;&nbsp;
        <input type="numberS" placeholder="Book Year" id="book_year" name="book_year" ><br/><br/>
        <label for="book_edition">Book Edition</label>&nbsp;&nbsp;&nbsp;
        <input type="text" placeholder="Book Edition" id="book_edition" name="book_edition"><br/><br/>
        <?php

	}

	


	public static function Save_Meta_Data_book($post_id)
    {
        global $wpdb,$post;
		$tablename = $wpdb->prefix.'metabox';

		
		/*if($wpdb->get_var("SHOW TABLES LIKE '$tablename'") != $tablename) {
			//if table not in database. Create new table
			
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $tablename ( 
				`id` INT , 
				`Author_Name` VARCHAR(100), 
				`price` INT , 
				`publisher` VARCHAR(100) , 
				`year` INT , 
				`edition` VARCHAR(100) , 
				PRIMARY KEY (`id`)) ENGINE = InnoDB;
			) $charset_collate;";
			
			dbDelta($sql);
		}*/


        $wpdb->insert(
            $tablename, [
            'post_id' => $post->ID,
            'author' => $_POST['author_name'],
            'price' => $_POST['book_price'],
            'publisher' => $_POST['book_publisher'],
            'year' => $_POST['book_year'],
            'edition' => $_POST['book_edition'], ],
            ['%s', '%d', '%s', '%d', '%s']
        );
        $wpdb->update(
            $tablename, [
            'author' => $_POST['author_name'],
            'price' => $_POST['book_price'],
            'publisher' => $_POST['book_publisher'],
            'year' => $_POST['book_year'],
            'edition' => $_POST['book_edition'], ],
            ['post_id' => $post->ID]
        );
    }

	


	public function create_custom_gutenburg_block()
	{
		wp_register_script(
			'custom-block-script', 
			plugins_url(__FILE__).'/book/widget/build/index.js',
	        ['wp-element', 'wp-blocks', 'wp-api-fetch', 'wp-components', 'wp-block-editor'],
        );

        wp_register_style(
            'custom-editor-css',
            plugins_url(__FILE__).'/book/widget/editor.css',
            []
        );

        wp_register_style(
            'custom-style-css',
            plugins_url(__FILE__).'/book/widget/style.css',
            []
        );


        register_block_type(
			'fancy-block-plugin/fancy-custom-block', [ 
            'editor_script' => 'custom-block-script',
            'editor_style' => 'custom-editor-css',
            'style' => 'custom-style-css',
            ]
        );
	 }

}
