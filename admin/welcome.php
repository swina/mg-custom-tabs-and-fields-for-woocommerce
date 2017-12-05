<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//main
function mg_wc_ctcf_main(){
  ?>
  <h1>Product Custom Tabs & Fields for Woocommerce</h1>
  <div style="width:97%;">
    <img src="<?php echo plugin_dir_url( __FILE__ );?>mg-custom-tabs-fields-for-woocommerce-banner.jpg" style="width:100%;height:auto;">
  </div>
  <div style="width:100%;text-align:center;display:block;height:80vh;margin:0 auto;">
  <div style="width:31%;background:#fff;border:1px solid #cecece;display:block;padding:0px 5px 0px 0px;float:left;margin-right:10px;text-align:center;min-height:200px;">
    <h3 style="
    width: 100%;
    background: #daecff;
    margin: 0 auto;
    padding: 10px 0px 10px 5px;
    clear:both;">Custom Tabs</h3>
    <div style="width:100%;display:block;padding:5px;min-height:90px;"><p>Add custom tabs to your shop products. Filter custom tabs to display on product categories.</p>
    </div>
    <a href="edit.php?post_type=mg_wc_tab"><button class="button button-primary" style="position:relative;bottom:0;">Create a Custom Tab</button></a>

  </div>
  <div style="width:31%;background:#fff;border:1px solid #cecece;display:block;padding:0px 5px 0px 0px;float:left;margin-right:10px;text-align:center;min-height:200px;">
    <h3 style="
    width: 100%;
    background: #daecff;
    margin: 0 auto;
    padding: 10px 0px 10px 5px;
    clear:both;">Custom Fields</h3>
    <div style="width:100%;display:block;padding:5px;min-height:90px;"><p>Add rich text custom fields to your shop products. Filter custom fields to display on product categories.</p>
    </div>
    <a href="admin.php?page=menu-posts-mg_wc_custom_fields"<button class="button button-primary" style="position:relative;bottom:0;">Create a Custom Field</button></a>
  </div>
  <div style="width:31%;background:#fff;border:1px solid #cecece;display:block;padding:0px 5px 0px 0px;float:left;margin-right:10px;text-align:center;min-height:200px;">
    <h3 style="
    width: 100%;
    background: #daecff;
    margin: 0 auto;
    padding: 10px 0px 10px 5px;
    clear:both;">License</h3>
    <div style="width:100%;display:block;padding:5px;min-height:90px;"><p>Custom Tabs & Fields for Woocommerce is a <strong>free</strong> to use plugin released under GPL licence.</p>
    </div>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="PR5979HT68HGN">
      <input type="image" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online.">
      <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>

  <table class="wp-list-table widefat fixed striped tags">
    <thead>
      <th colspan="2"><h2>General Info</h2></th>
    </thead>
    <tbody>
      <tr>
        <th width="20%">Support</th>
        <td align="left">github.com</td>
      </tr>
      <tr>
        <th width="20%">Version</th>
        <td align="left">1.0.0 beta</th>
      </tr>
      <tr>
        <th width="20%">License</th>
        <td align="left">GPL 3</th>
      </tr>

      <tr>
        <th width="20%">Author</th>
        <td align="left">A. Nardone (moodgiver)</td>
      </tr>

      <tr>
        <th width="20%">Contributors</th>
        <td align="left">If you plan to contribute please contact me.</td>
      </tr>
      <tr>
        <th width="20%">PHP Version</th>
        <td align="left"><?php echo phpversion();?></td>
      </tr>
      <tr>
        <tr>
          <th width="20%">jQuery</th>
          <td align="left"><?php if ( wp_script_is('jquery') ) {
            echo 'YES';
          }  else {
            echo 'NO (required)';
          } ?></td>
        </tr>

    </tbody>
  </table>

</div>
  <?php
}
