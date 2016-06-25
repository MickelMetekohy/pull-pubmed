<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com/
 * @since             1.0.0
 * @package           Mkr_Pubmed
 *
 * @wordpress-plugin
 * Plugin Name:       PULL PUBMED
 * Plugin URI:        http://example.com/mkr-pubmed
 * Description:       This wordpress plugin grabs data related to a PMID from Pubmed.
 * Version:           1.0.0
 * Author:            Mickel Metekohy
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mkr-pubmed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mkr-pubmed-activator.php
 */
function activate_mkr_pubmed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mkr-pubmed-activator.php';
	Mkr_Pubmed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mkr-pubmed-deactivator.php
 */
function deactivate_mkr_pubmed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mkr-pubmed-deactivator.php';
	Mkr_Pubmed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mkr_pubmed' );
register_deactivation_hook( __FILE__, 'deactivate_mkr_pubmed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mkr-pubmed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mkr_pubmed() {

	$plugin = new Mkr_Pubmed();
	$plugin->run();

}
run_mkr_pubmed();
