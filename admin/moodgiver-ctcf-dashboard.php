<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//main
function mg_wc_ctcf_main(){
  ?>
  <h1>Product Custom Tabs & Fields for Woocommerce</h1>
  <div class="mg-header">
    <img src="<?php echo plugin_dir_url( __FILE__ );?>mg-custom-tabs-fields-for-woocommerce-banner.jpg"/>
  </div>
  <div class="mg-container">

  <div class="mg-col-3">
    <h3><?php echo __('Custom Fields','mg-tabs-and-fields-for-woocommcerce');?></h3>
    <div class="content"><p><?php _e('Add rich text custom fields to your shop products. Filter custom fields to display on product categories.','mood_ctcf');?></p>
    </div>
    <a href="admin.php?page=menu-posts-mg_wc_custom_fields"><button class="button button-primary"><?php _e('Create a Custom Field','mood_ctcf');?></button></a>
  </div>

  <div class="mg-col-3">
    <h3><?php _e('Custom Tabs','mood_ctcf');?></h3>
    <div class="content"><p><?php _e( 'Add custom tabs to your shop products. Filter custom tabs to display on product categories.','mood_ctcf');?></p>
    </div>
    <a href="edit.php?post_type=mg_wc_tab"><button class="button button-primary"><?php _e( 'Create a Custom Tab' , 'mood_ctcf');?></button></a>
  </div>

  <div class="mg-col-3">
    <h3>DB Optimize</h3>
    <div class="content"><p><?php _e('Optimize your DB cleaning all unnecessary data.','mood_ctcf');?></p>
    </div>
      <a href="admin.php?page=menu-posts-mg_wc_db_optimize"><button class="button button-primary"><?php _e('Optimize DB','mood_ctcf');?></button></a>
  </div>

  <div class="mg-col-3">
    <h3><?php _e('Sample CSV for custom fields','mood_ctcf');?></h3>
    <div class="content">
      <p><?php _e('Import products custom fields using the sample CSV based on your settings','mood_ctcf');?></p>
    </div>
    <a href=" admin.php?page=menu-posts-mg_wc_csv_sample"><button class="button button-primary"><?php _e('Create sample CSV','mood_ctcf');?></button></a>
  </div>

  <div class="mg-col-3">
    <h3><?php _e('Documentation and Issues','mood_ctcf');?></h3>
    <div class="content">
      <p><?php _e('Check our documentation in order to start using this plugin','mood_ctcf');?></p>
    </div>
    <a href=" https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce" target="_blank"><button class="button button-primary"><?php _e('Read Docs','mood_ctcf');?></button></a>
  </div>


  <div class="mg-col-3">
    <h3><?php _e('License','mood_ctcf');?></h3>
    <div class="content"><p><?php _e('Custom Tabs & Fields for Woocommerce is a <strong>free</strong> to use plugin released under GPL licence.','mood_ctcf');?></p>
    </div>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="PR5979HT68HGN">
      <input type="image" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online.">
      <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>
<div style="display:block;width:100%;clear:both;">
  <p>
    <small>Custom Tabs & Fields for Woocommerce &copy; <?php echo date('Y');?> - Antonio Nardone</small>
  </p>
</div>
  <?php
}
