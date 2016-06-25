<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/public
 * @author     Mickel Metekohy <m.star28@gmail.com>
 */
class Mkr_Pubmed_Public {

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
		 * defined in Mkr_Pubmed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mkr_Pubmed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mkr-pubmed-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );

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
		 * defined in Mkr_Pubmed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mkr_Pubmed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('jquery');

		wp_enqueue_script( $this->plugin_name . 'jquery-ui' , plugin_dir_url( __FILE__ ) . 'js/jquery.ui.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mkr-pubmed-public.js', array($this->plugin_name . 'jquery-ui'), $this->version, true );
	}




	//set up some shortcodes
	public function show_all_mkr_pubmed_publications_shortcode( $atts, $content = NULL ) {
		$content = NULL;
		global $wpdb;
		$table_name = $wpdb->prefix . 'publications';
		$pmps = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY pub_date DESC" );

    $output = '';

		echo '<section id="pm-accordion-wrap"><div id="accordion">';
		foreach($pmps as $pmp) {
			include plugin_dir_path( __FILE__ ) . 'partials/mkr-pubmed-public-display.php';
		}
		echo '</div></section>';

    return $output;

	}

	public function show_all_mkr_pubmed_publications_register_shortcode() {
		add_shortcode( 'ag-pubmed', [$this, 'show_all_mkr_pubmed_publications_shortcode'] );
	}


} //end class
