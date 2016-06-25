<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/admin
 * @author     Mickel Metekohy <m.star28@gmail.com>
 */
class Mkr_Pubmed_Admin {

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
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
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
		 * defined in Mkr_Pubmed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mkr_Pubmed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mkr-pubmed-admin.css', array(), $this->version, 'all' );

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
		 * defined in Mkr_Pubmed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mkr_Pubmed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mkr-pubmed-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * helpers
	 */

	 /**
 	 * error handeling
 	 */
	public function mkr_pubmed_admin_notices($message, $notice = '') {
		switch($notice) {
			case 'error' :
				$class = 'notice notice-error is-dismissible';
				break;
			case 'success' :
				$class = 'notice notice-success is-dismissible';
				break;
			default :
				$class = 'notice is-dismissible';
				break;
		}
		$message = __( $message, 'mkr-pubmed' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}


	/**
	 * create pages
	 */
	public function mkr_pubmed_create_admin_pages() {
		//add an item to the menu
    add_menu_page (
      'All Publications', 'Publications', 'manage_options', 'publications-admin', [$this, 'mkr_pubmed_all_page'], '', '3.1665909'
    );
		$hook = add_submenu_page (
			'publications-admin', 'All Publications', 'All Publications', 'manage_options', 'publications-admin', [$this, 'mkr_pubmed_all_page']
		);
		add_action( "load-$hook", [ $this, 'screen_option' ] );
		add_submenu_page (
			'publications-admin', 'Add Publications', 'Add Publications', 'manage_options', 'publications-add', [$this, 'mkr_pubmed_add_page']
		);
		add_submenu_page (
			'publications-admin', 'Settings', 'Settings', 'manage_options', 'publications-settings', [$this, 'mkr_pubmed_settings_page']
		);
	}

	/**
	 * settings page
	 */
	public function mkr_pubmed_settings_page() {
		require_once plugin_dir_path( __FILE__  ) . 'partials/mkr-pubmed-admin-settings-display.php';
	}

	public function mkr_pubmed_settings_page_settings() {
		register_setting( 'mkr-pubmed-settings-group', 'mkr-pubmed-api-url' );
		add_settings_section( 'mkr-pubmed-settings-section-api-url', 'API Options', [$this, 'mkr_pubmed_settings_section_description'], 'publications-settings' );
		add_settings_field( 'mkr-pubmed-settings-group', 'API URL', [$this, 'mkr_pubmed_settings_field_api_url'], 'publications-settings', 'mkr-pubmed-settings-section-api-url', array('label_for' => 'mkr-pubmed-api-url') );
	}

	public function mkr_pubmed_settings_section_description() {
		echo 'Use "[ID]" as a placeholder for the publication ID.';
	}

	public function mkr_pubmed_settings_field_api_url() {
		$api_url = esc_attr(get_option( 'mkr-pubmed-api-url' ));
		echo '<input type="text" id="mkr-pubmed-api-url" name="mkr-pubmed-api-url" placeholder="Enter API URL" value="' . $api_url . '">';
	}




	/**
	 * add page
	 */
	public function mkr_pubmed_add_page() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/mkr-pubmed-admin-add-display.php';
 	}
	public function mkr_pubmed_add_page_settings() {
		register_setting( 'mkr-pubmed-add-group', 'mkr-pubmed-add-publication' );
		add_settings_section( 'mkr-pubmed-add-section-add-publication', NULL, [$this, 'mkr_pubmed_add_section_description'], 'publications-add' );
		add_settings_field( 'mkr-pubmed-add-group', 'Add Publication', [$this, 'mkr_pubmed_add_field_add_publication'], 'publications-add', 'mkr-pubmed-add-section-add-publication', array('label_for' => 'mkr-pubmed-add-publication') );
	}

	public function mkr_pubmed_add_section_description() {
		return;
	}

	public function mkr_pubmed_add_field_add_publication() {
		echo '<input type="text" id="mkr-pubmed-add-publication" name="mkr-pubmed-add-publication" placeholder="Enter Publication ID">';
	}

	public function mkr_pubmed_add_publication() {

		//check if PMID is numeric and asign to variable
		if(!is_numeric($PMID = trim($_POST['mkr-pubmed-add-publication']))) {
			$this->mkr_pubmed_admin_notices(__('Publication not found.', 'mkr-pubmed'), 'error');
			return;
		}

		// check if the PMID already exists
		global $wpdb;
		$table_name = $wpdb->prefix . 'publications';

		$find_publication = $wpdb->get_results( "SELECT PMID FROM $table_name WHERE PMID = $PMID" );

		if($find_publication) {
			$this->mkr_pubmed_admin_notices(__('Publication has already been added.', 'mkr-pubmed'), 'error');
			return;
		}

		//make api call
		if(!$api_url = get_option('mkr-pubmed-api-url')) {
			$this->mkr_pubmed_admin_notices(__('Please provide the API URL on the <a href="/wp-admin/admin.php?page=publications-settings">settings</a> page.', 'mkr-pubmed'), 'error');
			return;
		}
		$api_url = file_get_contents(str_replace('[ID]', $PMID, $api_url), 0);

		//interpret xml retun from api
		$pubmed_record = new SimpleXMLElement($api_url);

		//check if record exists
		if(count($pubmed_record) <= 0) {
			$this->mkr_pubmed_admin_notices(__('Publication with PMID "'.$PMID.'" not found.', 'mkr-pubmed'), 'error');
			return;
		}

		//assign data to variables
		$PMID = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->PMID) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->PMID : '';

		$journal = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->Title) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->Title : '';
		// $journal = ucwords($journal);

		$pages = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Pagination->MedlinePgn) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Pagination->MedlinePgn : '';

		$volume = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->JournalIssue->Volume) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->JournalIssue->Volume : '';

		$issue = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->JournalIssue->Issue) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->JournalIssue->Issue : '';

		$year = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year : '';

		$pub_date = '';
		if($pub_date = $pubmed_record->PubmedArticle[0]->MedlineCitation->ArticleDate) {
			$pub_date = $pub_date->Year . '-' . $pub_date->Month . '-' . $pub_date->Day;
		} elseif($pub_date = $pubmed_record->PubmedArticle[0]->MedlineCitation->DateCreated) {
			$pub_date = $pub_date->Year . '-' . $pub_date->Month . '-' . $pub_date->Day;
		} else {
			$pub_date = $year . '-00-00';
		}

		$journal_abbr = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->ISOAbbreviation) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Journal->ISOAbbreviation : '';

		$PMCID = '';
		if( $PMCIDS = $pubmed_record->PubmedArticle[0]->PubmedData->ArticleIdList->ArticleId ) {
			foreach($PMCIDS as $PMC) {
					if( strpos($PMC, 'PMC') !== false) {
						$PMCID = $PMC;
					}
			}
		}

		$pubmed_url = 'http://www.ncbi.nlm.nih.gov/pubmed/' . $PMID;

		$title = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->ArticleTitle) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->ArticleTitle : '';

		$abstract = isset($pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Abstract->AbstractText) ? $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->Abstract->AbstractText : '';

		$authors = '';
		if( $authors = $pubmed_record->PubmedArticle[0]->MedlineCitation->Article->AuthorList->Author ) {
			$authorlist = array();
			foreach($authors as $values) {
					$authorlist[] = $values->LastName . ' ' . $values->Initials;
			}
			$authors = implode(", ", $authorlist);
			$authors = rtrim($authors, ", ");
			$authors = addslashes($authors . '.');
		}

		//insert publication in the database
		$insert_publication = $wpdb->insert(
			$table_name,
			array(
				'date_added' => current_time( 'mysql' ),
				'PMID' => $PMID,
				'PMCID' => $PMCID,
				'journal' => $journal,
				'journal_abbr' => $journal_abbr,
				'issue' => $issue,
				'volume' => $volume,
				'page' => $pages,
				'year' => $year,
				'pub_date' => $pub_date,
				'authors' => $authors,
				'title' => $title,
				'abstract' => $abstract,
				'pubmed_url' => $pubmed_url
			)
		);


		//check if publication is added
		if($insert_publication) {
			$this->mkr_pubmed_admin_notices(__('Publication saved.', 'mkr-pubmed'), 'success');
		} else {
			$this->mkr_pubmed_admin_notices(__('Publication not found..', 'mkr-pubmed'), 'error');
		}

		// get last added post to print on partial $table_name
		$last_added = $wpdb->get_row("SELECT * FROM $table_name ORDER BY date_added DESC", OBJECT, 0);
	} //end add publication


	public function mkr_pubmed_get_latest_publication() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'publications';
		if($last_added = $wpdb->get_row("SELECT * FROM $table_name ORDER BY date_added DESC", OBJECT, 0)) {
			return $last_added;
		}
		return false;
	}


	/**
	 * all page
	 */
	public function mkr_pubmed_all_page() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/mkr-pubmed-admin-all-display.php';
 	}

	//functions to interact with the admin table class that extends wp table list

	// publications WP_List_Table object
	public $publications_obj;

	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	/**
	 * Screen options
	 */
	public function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => 'Publications',
			'default' => 5,
			'option'  => 'publications_per_page'
		];

		add_screen_option( $option, $args );

		$this->publications_obj = new Mkr_Pubmed_Admin_table($this->plugin_name, $this->version);
	}


} // end class
