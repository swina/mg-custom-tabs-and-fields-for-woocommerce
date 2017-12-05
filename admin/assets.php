<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function my_assets() {
  wp_register_script ( 'modaljs' , plugin_dir_url( __FILE__ ) . 'assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '1', true );
  wp_register_style ( 'modalcss' , plugin_dir_url( __FILE__ ) . 'assets/bootstrap/css/bootstrap.css', '' , '', 'all' );

  wp_register_script ( 'pluginjs' , plugin_dir_url( __FILE__ ) . 'assets/js/cfmb.js', array( 'jquery' ), '1', true );
  wp_register_style ( 'plugincss' , plugin_dir_url( __FILE__ ) . 'assets/css/cfmb.css', '' , '', 'all' );

  wp_enqueue_script( 'modaljs' );
  wp_enqueue_script( 'pluginjs' );
  wp_enqueue_style( 'modalcss' );
  wp_enqueue_style( 'plugincss' );
}
