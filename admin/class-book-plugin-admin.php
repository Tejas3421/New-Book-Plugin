<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @category   Description
 * @package    Book_Plugin
 * @subpackage Book_Plugin/admin
 * @author     tejas Patle <tejas.patle@hbwsl.com>
 * @license    GPL v3
 * @link       http://localhost/WordPress/
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @category   Description
 * @package    Book_Plugin
 * @subpackage Book_Plugin/admin
 * @author     tejas Patle <tejas.patle@hbwsl.com>
 * @license    GPL v3
 * @link       http://localhost/WordPress/
 * @since      1.0.0
 */
class Book_Plugin_Admin {


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
	 * Initialization of constructor
	 *
	 * @param [type] $plugin_name Book PLugin.
	 * @param [type] $version   v1.0.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
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

	/**
	 * Register my cusom post type Book
	 *
	 * @return void
	 */
	public function register_custom_post_type_books() {
		$labels = array(
			'name'          => 'Books',
			'singular-name' => 'Book',
		);

		// array of element support by our post type.
		$supports = array( 'title', 'editor', 'thumbnail', 'comments', 'excerpts' );

		$options = array(
			'labels'     => $labels,
			'public'     => true,
			'rewrite'    => array( 'slug' => 'book' ),
			'supports'   => $supports,
			'taxonomies' => array( 'book-catagory', 'book-tag' ),
		);

		// registering custom post type.
		register_post_type( 'book', $options );

	}


	/**
	 * Created custom hierarchical taxonomy
	 *
	 * @return void
	 */
	public function register_custom_hierarchical_taxonomy_book_catagery() {
		$labels = array(
			'name'          => 'Books Catagories',
			'singular-name' => 'Book Catagory',
		);

		$options = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'book-catagory' ),
			'show_admin_column' => false,
		);

		// register catagory for Book post type.

		register_taxonomy( 'book-catagory', array( 'book' ), $options );
	}



	/**
	 * Cretaing non hierarchical taxonomy
	 *
	 * @return void
	 */
	public function register_non_hierarchical_taxonomy_book_tag() {

		$labels = array(
			'name'              => 'Book Tags',
			'singular_name'     => 'Book Tag',
			'parent_item'       => null,
			'parent_item_colon' => null,
			'public'            => true,
		);

		$options = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_in_rest'      => true,
			'show_admin_column' => false,
			'rewrite'           => array( 'slug' => 'book-tag' ),
		);

		// registering taxonomy for book tag.
		register_taxonomy( 'book-tag', 'book', $options );
	}



	/**
	 * Adding a MEnu Page for Book
	 *
	 * @return void
	 */
	public function add_menu_page_book() {
		// added submenu section Book setting inn Book POst Type.
		add_submenu_page(
			'edit.php?post_type=book', // $parent_slug
			'Book Settings Page',  // $page_title
			'Book Settings',        // $menu_title
			'manage_options',           // $capability
			'book_Settings-page', // menu slug.
			array( self::class, 'Book_Setting_Page_book' ) // $function
		);

	}


	/**
	 * Creating settings page for book
	 *
	 * @return void
	 */
	public static function book_setting_page_book() {

		// check for currency and no of post per page is given or not.
		if ( isset( $_POST['currency'] ) && isset( $_POST['no_of_post'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['currency'] ) ), 'wpdocs-my-nonce' ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['no_of_post'] ) ), 'wpdocs-my-nonce' ) ) {

			// saving entered data in variable.
			$currency   = sanitize_text_field( wp_unslash( $_POST['currency'] ) );
			$no_of_post = sanitize_text_field( wp_unslash( $_POST['no_of_post'] ) );

			update_option( 'book_currency', $currency );       // update currency option.
			update_option( 'book_no_of_post', $no_of_post );        // update no of post options.
		}

		// getting previous option.
		$options = get_option( 'book_currency' );

		?>

			<!--This is form for admin book setting menu page to select currency and no of post per page--->
			<h1>Book Setting Page</h1>
			<form method="post">
			<label for="currency">Currency</label>
			<select id="currency" name="currency">
			<option value="₹" <?php selected( $options, '₹' ); ?>>₹</option>
			<option value="$" <?php selected( $options, '$' ); ?>>$</option>
			<option value="€" <?php selected( $options, '€' ); ?>>€</option>
			</select>
			<br><br>
			<label for="no_of_post">No of post per page</label>
				<input type="number" id="no_of_post" placeholder="Eg. 4 or 5" name="no_of_post"><br/><br/>
				<input type="submit" class="button-primary" value="<?php esc_attr__( 'Save changes', 'bookdomain' ); ?>" />
			</form>	
		<?php

	}

	/**
	 * Adding shortcode
	 *
	 * @return void
	 */
	public function shortcode_adding_fucntion() {

		// added shortcode "Book".
		add_shortcode( 'Book', array( $this, 'new_shortcode_book' ) );
	}


	/**
	 * New shortcode fucntion for book shortcode
	 *
	 * @param array  $atts id,author_name,price.
	 * @param [type] $content content from page.
	 * @param string $tag tags.
	 *
	 * @return content
	 */
	public function new_shortcode_book( $atts = array(), $content = null, $tag = '' ) {

		$atts = shortcode_atts(
			array(
				'book_id'     => '',
				'author_name' => '',
				'price'       => '',
				'year'        => '',
				'publisher'   => '',
				'category'    => '',
				'tag'         => '',
			),
			$atts
		);

		$args = array(
			'post_type'   => 'book',
			'numberposts' => 100,
			'post_status' => 'publish',
			'meta_query'  => array(
				'relation' => 'OR',

			),
		);

		// adding attributes.
		if ( '' !== $atts['book_id'] ) {
			$args['p'] = $atts['book_id'];
		}

		if ( '' !== $atts['author_name'] ) {
			$args['meta_query'][] = array(
				'key'     => 'author_name',
				'value'   => sanitize_text_field( $atts['author_name'] ),
				'compare' => '=',
			);
		}

		if ( '' !== $atts['price'] ) {
			$args['meta_query'][] = array(
				'key'     => 'book_price',
				'value'   => $atts['price'],
				'compare' => '<',
			);
		}

		if ( '' !== $atts['year'] ) {
			$args['meta_query'][] = array(
				'key'     => 'book_year',
				'value'   => $atts['year'],
				'compare' => '=',
			);
		}

		if ( '' !== $atts['publisher'] ) {
			$args['meta_query'][] = array(
				'key'     => 'book_publisher',
				'value'   => sanitize_text_field( $atts['publisher'] ),
				'compare' => '=',
			);

		}

		if ( '' !== $atts['category'] ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'book-catagory',
				'field'    => 'slug',
				'terms'    => $atts['category'],
			);
		}

		if ( '' !== $atts['tag'] ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'book-tag',
				'field'    => 'slug',
				'terms'    => $atts['tag'],
			);
		}

		error_log(print_r($args, true));

		$query = new WP_Query($args);

		$c = '<div>';

		// looping through posts.
		foreach ( $postslist as $all_post ) {

			// printing details of book.

			$c .= '<div style="border: 2px solid black;background-color:white;">
                <p style="text-align:center;">ID of book     ' . esc_attr( $all_post->ID ) . '</p>
                <p style="text-align:center;">Author Name    ' . get_metadata( 'book', $all_post->ID, 'author_name', true ) . '</p>
                <p style="text-align:center;">Book Price     ' . get_metadata( 'book', $all_post->ID, 'book_price', true ) . '</p>
                <p style="text-align:center;">Publisher      ' . get_metadata( 'book', $all_post->ID, 'book_edition', true ) . '</p>
                <p style="text-align:center;">Book year      ' . get_metadata( 'book', $all_post->ID, 'book_year', true ) . '</p>
                <p style="text-align:center;">Book Publisher ' . get_metadata( 'book', $all_post->ID, 'book_publisher', true ) . '</p>
                </div><br/>';
		}

		return $c;
	}

	/**
	 * Creating  Meta Box For Books
	 *
	 * @return void
	 */
	public function add_book_meta_box() {
		// added meta box in book post type.
		add_meta_box( 'book-meta-box', 'Book Meta Box', array( self::class, 'book_meta_fields' ), 'book' ); // adding meta box for book meta data.
	}


	/**
	 * Creating fields for book  meta data
	 *
	 * @return void
	 */
	public static function book_meta_fields() {

		// creating field for input meta data for book post type.
		?>
		<label for="author">Enter Book Author</label>
		<input type="text" placeholder="Enter author name" id="author" name="author_name" ><br/><br/>
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

	/**
	 * Updating post meta data in book meta tabel
	 *
	 * @param [type] $post_id POSTID.
	 *
	 * @return void
	 */
	public function update_book_meta_data( $post_id ) {
		// updating author name in  book meta table.
		if ( isset( $_POST['author_name'] ) ) {
			$author_name = sanitize_text_field( wp_unslash( $_POST['author_name'] ) );
			update_metadata( 'book', $post_id, 'author_name', $author_name );
		}

		// updating value of price in book meta table.
		if ( isset( $_POST['book_price'] ) ) {
			$book_price = sanitize_text_field( wp_unslash( $_POST['book_price'] ) );
			update_metadata( 'book', $post_id, 'book_price', $book_price );
		}

		// updating value of publisher in meta table.
		if ( isset( $_POST['book_publisher'] ) ) {
			$book_publisher = sanitize_text_field( wp_unslash( $_POST['book_publisher'] ) );
			update_metadata( 'book', $post_id, 'book_publisher', $book_publisher );
		}

		// updating value of year in book meta table.
		if ( isset( $_POST['book_year'] ) ) {
			$book_year = sanitize_text_field( wp_unslash( $_POST['book_year'] ) );
			update_metadata( 'book', $post_id, 'book_year', $book_year );
		}

		// updating value of edition in book meta table.
		if ( isset( $_POST['book_edition'] ) ) {
			$book_edition = sanitize_text_field( wp_unslash( $_POST['book_edition'] ) );
			update_metadata( 'book', $post_id, 'book_edition', $book_edition );
		}
	}


	/**
	 * Creating a dashboard widget for admin view
	 *
	 * @return void
	 */
	public function book_admin_dashboard_widget() {

		// add dashboard widget in admin dashboard.

		wp_add_dashboard_widget(
			'book_admin_dashboard_widget',
			'book_admin_dashboard_widget Title',
			array( self::class, 'book_admin_dashboard_widget_callback' )
		);
	}


	/**
	 * Call back fcuntion for admin widget shows the output in admin dashboard
	 *
	 * @return void
	 */
	public static function book_admin_dashboard_widget_callback() {

		// Output of dashboard widget to get 5 catagories.

		echo '<h2>This is my admin widget to get top 5 catagories</h2>';
		$args = array(
			'taxonomy' => 'book-catagory',
			'orderby'  => 'count',
			'order'    => 'DESC',
		);

		// getting catagories based on filter above.
		$cats  = get_categories( $args );
		$count = 0;

		// looping through catagories.
		foreach ( $cats as $cat ) {
			if ( 5 === $count ) {
				// break after 5 top catagories.
				break;
			} else {
				// display catagory name and its count.
				$c = '<p style="color:green;">' . esc_attr( $cat->name );
				' ' . esc_attr( $cat->count );
				'</p>';
				$count++;
				echo esc_attr( $c );
			}
		}
	}
	/**
	 * Rregistering new meta table book
	 *
	 * @return void
	 */
	public function register_metatable() {
		global $wpdb;
		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
		$wpdb->tables[] = 'bookmeta';
	}

}
