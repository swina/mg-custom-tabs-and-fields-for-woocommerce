<?php
/**
* Plugin Name: Moodgiver Custom Tabs & Fields for Woocommerce
* Plugin URI: https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce
* Description: Add custom tabs and custom rich text fields to Woocommerce products. Assign tabs to specific categories, assign custom fields to custom tabs. Assign custom fields to the default description tab. Create sample CSV file to be used to import custom fields data thru Woocommerce importer. Optimize DB for custom field data integrity.
* Version: 0.2a
* Author: Antonio Nardone
* Author URI: https://antonionardone.com
* License: GPL3
* Date: december 2017
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

  /* required files */
  /* main class functions */
  require_once dirname( __FILE__ ) . '/include/moodgiver.class.custom-tab-fields-manager.php';
  /* create CSV sample file to import data for products custom fields */
  require_once dirname( __FILE__ ) . '/admin/moodgiver-ctcf-admin-sample-csv.php';
  /* metabox admin manager */
  require_once dirname( __FILE__ ) . '/admin/moodgiver-ctcf-admin-meta-box.php';
  /* custom fields manager */
  require_once dirname( __FILE__ ) . '/admin/moodgiver-ctcf-admin-custom-fields.php';
  /* plugin dashboard */
  require_once dirname( __FILE__ ) . '/admin/moodgiver-ctcf-dashboard.php';

/* custom fields callback */
function mood_ctcf_custom_fields(){
  mood_ctcf_custom_fields_manager();
}

function moodgiver_ctcf_load_plugin_textdomain() {
  load_plugin_textdomain( 'mood_ctcf', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'moodgiver_ctcf_load_plugin_textdomain' );

/*load js, css and bootstrap modal*/
function mood_ctcf_plugin_assets() {
  wp_register_script ( 'modaljs' , plugin_dir_url( __FILE__ ) . 'assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '1', true );
  wp_register_style ( 'modalcss' , plugin_dir_url( __FILE__ ) . 'assets/bootstrap/css/bootstrap.css', '' , '', 'all' );
  wp_register_script ( 'pluginjs' , plugin_dir_url( __FILE__ ) . 'assets/js/moodgiver-ctcf.js', array( 'jquery' ), '1', true );
  wp_register_style ( 'plugincss' , plugin_dir_url( __FILE__ ) . 'assets/css/moodgiver-ctcf.css', '' , '', 'all' );
  wp_enqueue_script( 'modaljs' );
  wp_enqueue_script( 'pluginjs' );
  wp_enqueue_style( 'modalcss' );
  wp_enqueue_style( 'plugincss' );
  if ( !jQuery.ui ){
    wp_enqueue_script ( 'jquery-ui-sortable' );
    wp_enqueue_script ( 'jquery-ui-tooltip' );
  }
}

//action load boostrap and plugin jss / css
add_action('admin_enqueue_scripts', 'mood_ctcf_plugin_assets');

if ( !is_admin() ) {
  //in front end include custom css
  wp_register_style ( 'plugincssfrontend' , plugin_dir_url( __FILE__ ) . 'assets/css/moodgiver-ctcf.css', '' , '', 'all' );
  wp_enqueue_style( 'plugincssfrontend' );
}
