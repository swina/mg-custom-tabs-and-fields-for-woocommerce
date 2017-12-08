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
    <div class="content"><p><?php echo __('Add rich text custom fields to your shop products. Filter custom fields to display on product categories.','mg-tabs-and-fields-for-woocommcerce');?></p>
    </div>
    <a href="admin.php?page=menu-posts-mg_wc_custom_fields"><button class="button button-primary"><?php echo __('Create a Custom Field','mg-tabs-and-fields-for-woocommcerce');?></button></a>
  </div>

  <div class="mg-col-3">
    <h3><?php echo __('Custom Tabs','mg-tabs-and-fields-for-woocommcerce');?></h3>
    <div class="content"><p><?php echo __( 'Add custom tabs to your shop products. Filter custom tabs to display on product categories.','mg-tabs-and-fields-for-woocommcerce');?></p>
    </div>
    <a href="edit.php?post_type=mg_wc_tab"><button class="button button-primary"><?php echo __( 'Create a Custom Tab' , 'mg-tabs-and-fields-for-woocommcerce');?></button></a>
  </div>
  
  <div class="mg-col-3">
    <h3>DB Optimize</h3>
    <div class="content"><p>Optimize your DB cleaning all unnecessary data.</p>
    </div>
      <a href="admin.php?page=menu-posts-mg_wc_db_optimize"><button class="button button-primary">Optimize DB</button></a>
  </div>

  <div class="mg-col-3">
    <h3>Documentation</h3>
    <div class="content">
      <p>Check our documentation in order to start using this plugin</p>
    </div>
    <a href=" https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce" target="_blank"><button class="button button-primary">Read Docs</button></a>
  </div>

  <div class="mg-col-3">
    <h3>Support</h3>
    <div class="content">
      <p>For any issues or new features request</p>
    </div>
    <a href=" https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/issues" target="_blank"><button class="button button-primary">Open an issue</button></a>
  </div>
  <div class="mg-col-3">
    <h3>License</h3>
    <div class="content"><p>Custom Tabs & Fields for Woocommerce is a <strong>free</strong> to use plugin released under GPL licence.</p>
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
