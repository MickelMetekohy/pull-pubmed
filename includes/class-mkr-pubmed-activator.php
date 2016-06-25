<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/includes
 * @author     Mickel Metekohy <m.star28@gmail.com>
 */
class Mkr_Pubmed_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		/**
		 * setup databae table
		 * https://codex.wordpress.org/Creating_Tables_with_Plugins
		 */
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'publications';

		$sql = "CREATE TABLE $table_name (
		  id mediumint(20) NOT NULL AUTO_INCREMENT,
		  date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PMID varchar(40) NOT NULL,
			PMCID varchar(40) DEFAULT 'NOT SET' NOT NULL,
			journal varchar(255) DEFAULT 'NOT SET' NOT NULL,
			journal_abbr varchar(255) DEFAULT 'NOT SET' NOT NULL,
			issue varchar(100) DEFAULT 'NOT SET' NOT NULL,
			volume varchar(100) DEFAULT 'NOT SET' NOT NULL,
			page varchar(100) DEFAULT 'NOT SET' NOT NULL,
			year year(4) NOT NULL,
			pub_date date DEFAULT '0000-00-00' NOT NULL,
			authors text NOT NULL,
			title varchar(255) DEFAULT 'NOT SET' NOT NULL,
			abstract text NOT NULL,
			pubmed_url varchar(255) DEFAULT 'NOT SET' NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		/**
		 * refresh permalinks
		 * https://developer.wordpress.org/plugins/the-basics/activation-deactivation-hooks/
		 */
		flush_rewrite_rules();

	}



}
