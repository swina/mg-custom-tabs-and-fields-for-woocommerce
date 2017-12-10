<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function mood_ctcf_create_sample_csv(){
  ?>
  <h1>Custom Tabs & Fields for Woocommerce</h1>
  <h3><?php _e('CSV Data Sample','mood_ctcf');?></h3>
  <p>
  <?php _e('Following is the CSV Sample you can use to import your product custom fields','mood_ctcf');?>.
  </p>
  <p>
    <strong><?php _e('How to import your custom fields','mood_ctcf');?></strong>
    <ul class="mg-ul">
      <li class="mg-li"><?php _e('create your CSV following the downloaded sample','mood_ctcf');?></li>
      <li class="mg-li"><?php _e('import thru Woocommerce importer (update data if SKU exists option has to be checked','mood_ctcf');?></li>
      <li class="mg-li"><?php _e('map the custom fields columng as Import as meta','mood_ctcf');?></li>
    </ul>
  </p>
  <p><em><?php _e('File is generated according your settings','mood_ctcf');?>.</em></p>
  <?php
  $heading = 'SKU,';
  $custom_fields = get_option('mg_wc_cfmb');
  foreach ( $custom_fields AS $cf ){
    $heading .= 'Meta: mg_cf_'.$cf['name'].',';
  }
  $row = '0000001,';
  foreach ( $custom_fields AS $cf ){
    $row .= '[data for '.$cf['label'].'],';
  }
  $heading = rtrim($heading,',');
  $row = rtrim($row,',');
  $upload = wp_upload_dir();
  $upload_dir = $upload['basedir'];
  $plugin_name = $plugin_data['Name'];
  $upload_dir = $upload_dir . '/mg-tabs-and-fields-for-woocommerce';
  if (! is_dir($upload_dir)) {
     mkdir( $upload_dir, 0700 );
  }
  $filename = 'custom_fields_csv_sample.csv';
  $url = content_url().'/uploads/mg-tabs-and-fields-for-woocommerce';
  global $wp_filesystem;
  if ( ! $wp_filesystem->put_contents( $upload_dir .'/'.$filename, $heading.chr(10).$row, FS_CHMOD_FILE) ) {
    _e('Error saving file!','mood_ctcf');
  }
  echo '<a href="'.$url.'/'.$filename.'" target="_blank" class="button button-primary">Download CSV Sample</a>';
}
