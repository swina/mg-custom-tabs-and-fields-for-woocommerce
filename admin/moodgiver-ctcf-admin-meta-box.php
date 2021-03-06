<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//showing custom meta box for tabs
function mood_ctcf_show_custom_meta_box_mg_wc_tab() {
  global $post;
  $settings = array(
    'quicktags' => array('buttons' => 'em,strong,link',),
    'quicktags' => true,
    'tinymce' => true,
    'textarea_rows' => 5,
  );
  // Use nonce for verification to secure data sending
  wp_nonce_field('save_custom_tab','tabs_nonce');
  $order = $post;
  $order = get_post_meta( $post->ID, 'mg_wc_tab_order', true );
  $active = get_post_meta( $post->ID, 'mg_wc_tab_active', true );
  $footer = get_post_meta( $post->ID, 'mg_wc_tab_footer', true );
  //default order if not set or new tab
  if ( !$order ){
    $order = 10;
  }
  //active checkbox
  $checked = '';
  if ( $active ) $checked = 'checked';
?>
<!-- my custom value input -->
<table>
  <tr>
    <td width="25%">
      <?php _e('Order','mood_ctcf');?> [<span class="order-value"><?php echo $order;?></span>]
    </td>
    <td width="25%">
      <input type="range" min="1" max="20" class="mg_wc_tab_order" name="mg_wc_tab_order" value="<?php echo $order;?>">
    </td>
    <td align="center">
      <input type="checkbox" name="mg_wc_tab_active" <?php echo $checked;?>> <label><?php _e('Active','mood_ctcf');?></label>
    </td>
  </tr>
  <tr>
    <td colspan="3">
      <h4><?php _e('Global Footer','mood_ctcf');?></h4>
      <?php wp_editor( htmlspecialchars_decode($footer) , 'mg_wc_tab_footer' , $settings );
      ?>
    </td>
</table>

<?php
}

function mood_ctcf_show_custom_meta_box_mg_wc_tab_fields(){
  global $post;
  if ( isset($_POST['mg_wc_tab_custom_fields']) ){
    print_r(sanitize_text($_POST['mg_wc_tab_custom_fields']));
  }
  $fields = get_option('mg_wc_cfmb');
  ?>
  <ul>
    <?php
    if ( $fields ){
    foreach ( $fields AS $field ){
      $checked = '';
      if ( get_post_meta( $post->ID, 'mg_wc_tab_custom_field_'.$field['name'], true ) ){
        $checked = ' checked';
      }
      echo '<li><input type="checkbox" name="mg_wc_tab_custom_field_'.$field['name'].'" value="'.$field['name'].'"'.$checked.'>'.$field['label'].'</li>';
    }
    }
    ?>
  </ul>
  <?php
}

function mood_ctcf_show_product_meta_box_mg_wc_custom_fields(){
  ?>
  <div class="product_custom_field">'
  <?php
  //display fields
  global $woocommerce, $post;
  $options = get_option('mg_wc_cfmb');

  //editor settings;
  $settings = array(
    'quicktags' => array('buttons' => 'em,strong,link',),
    'quicktags' => true,
    'tinymce' => true,
    'textarea_rows' => 5,
  );
  if ( $options ){
    $au_meta = get_post_meta(get_the_ID());
    $aFieldsAdd = [];
    ?>
    <div class="custom_fields">

    <?php
    if ( $options ){
      foreach ( $options AS $key=>$value ){
        if ( !$value['custom_tab'] ){
          $field = $value['name'];
          $content = '';
          if ( $au_meta['mg_cf_'.$field] ){
            $meta = $au_meta['mg_cf_'.$field];
            $content = $meta[0];
          }

          if ( strlen($content) > 0 ){ ?>
            <div class="custom_field_saved_<?php echo $value['name'];?>">
              <h3><?php echo esc_attr($value['label']);?></h3>
              <textarea style="width:100%;" id="mg_cf_<?php echo $value['name'];?>_textarea" name="mg_cf_<?php echo $value['name']?>"><?php echo esc_attr($content);?></textarea>
              <span class="btn-editor btn-cf" data-field="mg_cf_<?php echo $value['name'];?>" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><span class="dashicons dashicons-edit"></span> Editor</span>
              <span class="btn-field-remove-saved btn-cf" data-field="<?php echo $value['name'];?>" style="cursor:pointer;">
                <span class="dashicons dashicons-trash"></span>
                <?php _e('Remove','mood_ctcf');?>
              </span>
              <span class="btn-custom-field-preview btn-cf" data-field="<?php echo $value['name'];?>" style="cursor:pointer" data-toggle="modal" data-target="cf_preview_modal"><span class="dashicons dashicons-visibility"></span> <?php _e('Preview','mood_ctcf');?></span>
            </div>
          <?php
          } else {
            $a = array (
              'name' => $value['name'],
              'label' => $value['label']
            );
            array_push($aFieldsAdd,$a);
          }
        }
      }
    }
    ?>
    </div>
    <div class="form-field" style="margin-top:20px;margin-bottom:20px;padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;width:100%;display:block;font-size:1.3em;">

    <?php _e('Add Custom Field','mood_ctcf');?> <select class="select_cfmb">
      <option value=""></option>
      <?php
        foreach ( $aFieldsAdd AS $key=>$value ){
          if ( !$value['custom_tab'] ){
            ?>
            <option value="<?php echo $value['name'];?>">
              <?php echo $value['label'];?>
            </option>
          <?php
          }
        }
       ?>
    </select>
    </div>
    <?php
  }
  ?>
  </div>


  <!-- Modal -->
  <div id="myModal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Custom Field Editor</h4>
      </div>

      <div class="modal-body">
      <?php
        wp_editor( htmlspecialchars_decode($content) , 'mg_cf_editor',$settings );
      ?>
      </div>
      <div class="modal-footer"><button class="button button-default" type="button" data-dismiss="modal"><?php _e('Close','mood_ctcf');?></button>
        <button class="button button-primary btn-save-cfmb" type="button"><?php _e('Save changes','mood_ctcf');?></button></div>
      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div id="cf_preview_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Custom Field <?php _e('Preview','mood_ctcf');?></h4>
      </div>

      <div class="modal-body">
        <p class="modal-body-cf_preview">
        </p>

      </div>
      <div class="modal-footer"><button class="button button-default" type="button" data-dismiss="modal"><?php _e('Close','mood_ctcf');?></button>
        <button class="button button-primary btn-save-cfmb" type="button"><?php _e('Save changes','mood_ctcf');?></button></div>
      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php
}
