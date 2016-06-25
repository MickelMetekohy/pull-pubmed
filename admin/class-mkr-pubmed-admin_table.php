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
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Mkr_Pubmed_Admin_table extends WP_List_Table {

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

		parent::__construct( [
			'singular' => __( 'Publication', 'mkr-pubmed' ), //singular name of the listed records
			'plural'   => __( 'Publications', 'mkr-pubmed' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

	}

	/**
	 * Retrieve publications data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_publications( $per_page = 5, $page_number = 1 ) {

	  global $wpdb;
		$table_name = $wpdb->prefix . 'publications';

	  $sql = "SELECT * FROM $table_name";
	  if ( ! empty( $_REQUEST['orderby'] ) ) {
	    $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
	    $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
	  }
	  $sql .= " LIMIT $per_page";
	  $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

	  $result = $wpdb->get_results( $sql, 'ARRAY_A' );

	  return $result;
	}

	/**
	 * Delete a publications record.
	 *
	 * @param int $id publication ID
	 */
	public static function delete_publication( $id ) {
	  global $wpdb;
		$table_name = $wpdb->prefix . 'publications';

	  $wpdb->delete(
	    $table_name,
	    [ 'id' => $id ],
	    [ '%d' ]
	  );
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
	  global $wpdb;
		$table_name = $wpdb->prefix . 'publications';

	  return $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
	}

	/** Text displayed when no customer data is available */
	public function no_items() {
	  _e( 'No publications avaliable.', 'mkr-pubmed' );
	}

	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_title( $item ) {

	  // create a nonce
	  $delete_nonce = wp_create_nonce( 'sp_delete_publication' );

	  $title = '<strong>' . $item['title'] . '</strong>';

	  $actions = [
	    'delete' => sprintf( '<a class="delete-publication" href="?page=%s&action=%s&publication=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
	  ];

	  return $title . $this->row_actions( $actions );
	}

	/**
	 * Render a column when no column specific method exists.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
	  switch ( $column_name ) {
	    case 'title':
	    case 'journal_abbr':
	    case 'year':
	    case 'issue':
	    case 'volume':
	    case 'page':
	    case 'PMID':
	      return $item[ $column_name ];
	    default:
	      return print_r( $item, true ); //Show the whole array for troubleshooting purposes
	  }
	}


	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
	  return sprintf(
	    '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
	  );
	}

	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
	  $columns = [
	    'cb'      => '<input type="checkbox" />',
	    'title'    => __( 'Title', 'mkr-pubmed' ),
	    'journal_abbr' => __( 'Journal', 'mkr-pubmed' ),
			'year'    => __( 'Year', 'mkr-pubmed' ),
	    'issue'    => __( 'Issue', 'mkr-pubmed' ),
	    'volume'    => __( 'Volume', 'mkr-pubmed' ),
	    'page'    => __( 'Page', 'mkr-pubmed' ),
	    'PMID'    => __( 'PMID', 'mkr-pubmed' )
	  ];

	  return $columns;
	}

	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
	  $sortable_columns = array(
	    'title' => 'title',
	    'year' => ['year', true],
	    'journal_abbr' => 'journal_abbr'
	  );

	  return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
	  $actions = [
	    'bulk-delete' => 'Delete'
	  ];

	  return $actions;
	}

	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

	  $this->_column_headers = $this->get_column_info();

	  /** Process bulk action */
	  $this->process_bulk_action();

	  $per_page     = $this->get_items_per_page( 'publications_per_page', 5 );
	  $current_page = $this->get_pagenum();
	  $total_items  = self::record_count();

	  $this->set_pagination_args( [
	    'total_items' => $total_items, //WE have to calculate the total number of items
	    'per_page'    => $per_page //WE have to determine how many items to show on a page
	  ] );


	  $this->items = self::get_publications( $per_page, $current_page );
	}

	public function process_bulk_action() {

	  //Detect when a bulk action is being triggered...
	  if ( 'delete' === $this->current_action() ) {

	    // In our file that handles the request, verify the nonce.
	    $nonce = esc_attr( $_REQUEST['_wpnonce'] );

	    if ( ! wp_verify_nonce( $nonce, 'sp_delete_publication' ) ) {
	      die( 'Go get a life script kiddies' );
	    }
	    else {
	      self::delete_publication( absint( $_GET['publication'] ) );
	    }

	  }

	  // If the delete bulk action is triggered
	  if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' ) ) {

    	$delete_ids = esc_sql( $_POST['bulk-delete'] );

	    // loop over the array of record IDs and delete them
	    foreach ( $delete_ids as $id ) {
	      self::delete_publication( $id );
	    }
	  }

	}

} // end class
