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
class Book_Catagory_Widget extends WP_Widget {

	/**
	 * Constructor for widget class
	 */
	public function __construct() {
		parent::__construct(
			'book_catagory_widget',
			'Book Catagory Widget',
			array( 'description' => __( 'WIdget For displaying book of same catagory' ) )
		);
	}

	/**
	 * Widget Output function
	 *
	 * @param [type] $args arguments.
	 * @param [type] $instance getting input from user.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$category = apply_filters( 'widget_category', $instance['category'] );

		echo esc_attr( $args['before_widget'] );

		if ( ! empty( $instance['category'] ) ) {

			echo 'Post from category ' . esc_attr( $category );

			$args = array(
				'post_type' => 'book',
				'taxonomy'  => 'book_catagory',
				'terms'     => $category,
			);

			$posts = new WP_Query( $args );

			// checking that category has post or not.
			if ( $posts->have_posts() ) :

				// looping through posts.
				while ( $posts->have_posts() ) :
					$posts->the_post();
					// printing title of that book.
					echo esc_attr( the_title() ) . '<br>';
				endwhile;

			endif;

		}

	}

	/**
	 * Form for user to get input
	 *
	 * @param [type] $instance getting instance of category.
	 * @return void
	 */
	public function form( $instance ) {

		if ( isset( $instance['category'] ) ) {
			$catagory = $instance['category'];
		} else {
			$catagory = __( 'New Category' );
		}

		$args = array(
			'taxonomy' => 'book-catagory',
			'orderby'  => 'name',
		);

		$cats = get_categories( $args );

			// form tag for entering category for widget.
		?>
		<div>
				<label for='category'><?php esc_attr_e( 'Category' ); ?></label>
				<select id='category' name='category' >
					<?php foreach ( $cats as $cat ) { ?>
						<option><?php echo esc_attr( $cat->name ); ?></option>
						<?php } ?>
				</select>
			</div>
		<?php
	}


	/**
	 * Updation function
	 *
	 * @param [type] $new_instance updating instance.
	 * @param [type] $old_instance getting old instance.
	 *
	 * @return void
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		return $instance;
	}

}
