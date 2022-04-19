<?php

/**
 * Fired during plugin activation
 *
 * @link  http://localhost/WordPress/
 * @since 1.0.0
 *
 * @package    Book_Plugin
 * @subpackage Book_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Book_Plugin
 * @subpackage Book_Plugin/includes
 * @author     Tejas Patle <tejas.patle@hbwsl.com>
 */
class Book_Plugin_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since 1.0.0
     */
    public static function activate()
    {

      /* global $wpdb;


        $tablename = $wpdb->prefix.'metabox';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tablename ( 
            `meta_id` INT NOT NULL AUTO_INCREMENT , 
            `post_id` INT NOT NULL , 
            `meta_key` VARCHAR NOT NULL , 
            `meta_value` VARCHAR NOT NULL , 
            PRIMARY KEY (`meta_id`)) ENGINE = InnoDB;
        ) $charset_collate;";

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';   

        dbDelta($sql);

*/
    global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	//$table_name = $wpdb->prefix . 'bookmeta';

	/*$sql = "CREATE TABLE {$wpdb->prefix}bookmeta (  
        `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  
        `book_id` bigint(20) unsigned NOT NULL,  
        `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,  
        `meta_value` longtext COLLATE utf8mb4_unicode_ci,  PRIMARY KEY (`meta_id`),  
        KEY `post_id` (`post_id`),  KEY `meta_key` (`meta_key`(191))) ENGINE=InnoDB AUTO_INCREMENT=4 
        DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";*/

    

	//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	

    

    global $wpdb;
	  
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
		
    // Create book meta table.
		$schema = "CREATE TABLE {$wpdb->prefix}bookmeta (
		meta_id bigint(20) NOT NULL AUTO_INCREMENT,
		book_id bigint(20) NOT NULL DEFAULT '0',
		meta_key varchar(255) DEFAULT NULL,
		meta_value longtext,
		PRIMARY KEY meta_id (meta_id),
		KEY book_id (book_id),
		KEY meta_key (meta_key)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;";

    dbDelta( $schema );


/*global $wpdb;

$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';

            
return;
*/
    }
}