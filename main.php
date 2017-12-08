<?php
/**
* Plugin Name: Moodgiver Custom Tabs & Fields for Woocommerce
* Plugin URI: https://github.com/swina/custom-fields-meta-box-for-woocommerce
* Description: Add custom tabs and custom rich text fields to Woocommerce products. Assign tabs to specific categories, assign custom fields to custom tabs, add custom fields to products on the fly.
* Version: 1.0
* Author: Antonio Nardone
* Author URI: https://antonionardone.com
* License: GPL3
* Date: december 2017
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* required files */
require_once dirname( __FILE__ ) . '/include/class.mg_custom-tab-fields-manager.php';
require_once dirname( __FILE__ ) . '/admin/admin-meta-box.php';
require_once dirname( __FILE__ ) . '/admin/admin-custom-fields.php';
require_once dirname( __FILE__ ) . '/admin/welcome.php';

/* custom fields callback */
function mg_ctcf_custom_fields(){
  mg_ctcf_custom_fields_manager();
}

/*load js, css and bootstrap modal*/
function mg_ctcf_plugin_assets() {
  wp_register_script ( 'modaljs' , plugin_dir_url( __FILE__ ) . 'assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '1', true );
  wp_register_style ( 'modalcss' , plugin_dir_url( __FILE__ ) . 'assets/bootstrap/css/bootstrap.css', '' , '', 'all' );
  wp_register_script ( 'pluginjs' , plugin_dir_url( __FILE__ ) . 'assets/js/cfmb.js', array( 'jquery' ), '1', true );
  wp_register_style ( 'plugincss' , plugin_dir_url( __FILE__ ) . 'assets/css/cfmb.css', '' , '', 'all' );
  wp_enqueue_script( 'modaljs' );
  wp_enqueue_script( 'pluginjs' );
  wp_enqueue_style( 'modalcss' );
  wp_enqueue_style( 'plugincss' );
  if ( !jQuery.ui ){
    wp_enqueue_script ( 'jquery-ui-sortable' );
  }
}

//action load boostrap and plugin jss / css
add_action('admin_enqueue_scripts', 'mg_ctcf_plugin_assets');

if ( !is_admin() ) {
  wp_register_style ( 'plugincssfrontend' , plugin_dir_url( __FILE__ ) . 'assets/css/cfmb.css', '' , '', 'all' );
  wp_enqueue_style( 'plugincssfrontend' );
}
