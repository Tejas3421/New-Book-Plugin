<?php
/**
 * Class For Book Catagory Widget
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
		$category = apply_filters( 'widget_title', $instance['category'] );

		if ( ! empty( $instance['category'] ) ) {

			echo $args['before_title'] . esc_attr( 'Post from category ' ) . esc_attr( $category ) . $args['after_title'];

			$args = array(
				'post_type' => 'book',
				'tax_query' => array(
					array(
						'taxonomy' => 'book-catagory',
						'field'    => 'slug',
						'terms'    => $category,
					),
				),
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
	 * Form for selecting category
	 *
	 * @param [type] $instance instance of category.
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
		);

		$cats = get_categories( $args );

		?>
		<div>
				<label for='<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>'><?php esc_attr_e( 'Category' ); ?></label>
				<select class='widefat' type='text' id='<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>' name='<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>' >
				<?php foreach ( $cats as $cat ) { ?>
						<option value="<?php echo esc_attr( $cat->name ); ?>" ><?php echo esc_attr( $cat->name ); ?></option>
						<?php } ?>
				</select>
			</div>
		<?php
	}

	/**
	 * Updating function for instance category
	 *
	 * @param [type] $new_instance newinstance for category.
	 * @param [type] $old_instance Oldinstance for category.
	 * @return string
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = array();
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		return $instance;
	}

}

