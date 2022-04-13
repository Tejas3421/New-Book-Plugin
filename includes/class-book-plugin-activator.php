<?php

/**
 * Fired during plugin activation
 *
 * @link       http://localhost/WordPress/
 * @since      1.0.0
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
class Book_Plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;


		$tablename = $wpdb->prefix.'metabox';
		$charset_collate = $wpdb->get_charset_collate();
		

		$sql = "CREATE TABLE $tablename ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`Author name` VARCHAR(100) NOT NULL , 
			`price` INT NOT NULL , 
			`publisher` VARCHAR(100) NOT NULL , 
			`year` INT NOT NULL , 
			`edition` VARCHAR(100) NOT NULL , 
			PRIMARY KEY (`id`)) ENGINE = InnoDB;
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');	
		dbDelta($sql);

	}

}
