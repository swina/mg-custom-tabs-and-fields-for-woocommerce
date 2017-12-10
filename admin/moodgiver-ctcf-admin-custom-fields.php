<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


//custom fields output Settings
function mood_ctcf_settings(){
  $options = get_option('mood_ctcf_settings');
  if ( !$options ){
    $customfield_layout = 'table';
  } else {
    $customfield_layout = $options['customfields_layout'];
  }
  ?>
  <h3>Custom Fields Layout settings</h3>
  <input type="radio" name="mood_ctcf_settings_layout" value="table" <?php echo esc_attr($customfield_layout) == 'table' ? 'checked="checked"' : '';?>> Table
  <input type="radio" name="mood_ctcf_settings_layout" value="paragraph" <?php echo esc_attr($customfield_layout) == 'paragraph' ? 'checked="checked"' : '';?>> Paragraph
  <p><small>This option sets the layout output of the custom fields in the product page</small></p>
  <?php
}

//custom fields manager
function mood_ctcf_custom_fields_manager(){
  if ( isset($_POST['mg_ctcf_save']) ){
    $values = mood_ctcf_custom_fields_save();
  } else {
    $values = get_option('mg_wc_cfmb');
  }

  ?>

<form method="POST" id="cfmb_form">
<input type="hidden" name="mg_ctcf_save" value="1">
<div class="wrap">
  <h1 class="wp-heading-inline">Custom Fields for Woocommerce</h1>

  <div class="alert alert-warning">You settings are changed. Save your changes</div>

</div>
<table class="wp-list-table widefat fixed striped posts ui-sortable custom-fields-table">
  <thead>
    <tr>
      <td colspan="6">
        <h3>Custom Fields</h3>
      </td>
  <tr>
  <tr class="table-options-row">
    <td title="Assign a name to tde custom field like Information,Technical specs., etc">Field Label</td>
    <!--<td>Slug</td>-->
    <td title="Enable output of tde custom field" style="text-align:center">Enabled</td>
    <td title="Add to the default description tab">Description Tab</td>
    <td title="Custom Tab">Custom Tab</td>
    <td title="Display after product meta data">Product Page Meta</td>
    <td>&nbsp;</td>
  </tr>
</thead>
  <tbody class="field_rows">


<?php
    if ( $values ){
      $tabs = get_posts(
        array(
            'post_type' => 'mg_wc_tab',
            'posts_per_page' => -1,
        )
        );

    foreach ( $values AS $key=>$v ){
      if ( isset($v['name']) ){
          $custom_tab = '';
          foreach ( $tabs AS $tab ){
            $tab_fields = get_post_meta($tab->ID,'mg_wc_tab_custom_field_'.$v['name']);
            if ( $tab_fields ){
              $custom_tab = $tab->post_title;
            }
          }
        ?>

        <tr id="row_<?php echo $v['name'];?>" class="field_row">
          <td>
            <input type="hidden" name="name_<?php echo $v['name'];?>" value="<?php echo $v['name'];?>">
            <input type="text" name="label_<?php echo $v['name'];?>" value="<?php echo $v['label'];?>">
          </td>

          <td align="center">
            <input type="checkbox" name="active_<?php echo $v['name']?>"  <?php echo esc_attr( $v['active'] ) == '1' ? 'checked="checked"' : ''; ?>>
          </td>
          <td>
            <input type="checkbox" name="tab_description_<?php echo $v['name']?>"  <?php echo esc_attr( $v['tab_description'] ) == '1' ? 'checked="checked"' : ''; ?>>
          </td>

          <td>
            <?php echo $custom_tab;?>
          </td>

          <td>
            <input type="checkbox" name="meta_<?php echo $v['name']?>"  <?php echo esc_attr( $v['meta'] ) == '1' ? 'checked="checked"' : ''; ?>>
          </td>
          <td><a href="#" class="btn_delete" data-field="<?php echo $v['name'];?>"><span class="dashicons dashicons-trash"></span></a>&nbsp;<span class="dashicons dashicons-menu"></span></td>
        </tr>
      <?php
      }
     }
    }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="6" class="cfmb_new_option hide">
        <label>Add new field</label>
        <input type="text" name="cfmb_new_field" placeholder="input field label"  style="width:100%;font-size:1.3em;">
      </td>
    </tr>

    <tr>
      <td colspan="6">
        <span class="button button-default btn-show" data-target="cfmb_new_option">Add a new field</span> <button class="button button-primary">Save changes</button>
      </td>
    </tr>

    <tr>
      <td colspan="6">
        <?php
          //custom fields layout setting
          mood_ctcf_settings();
        ?>
      </td>
    </tr>


    <tr>
      <td colspan="6">
        <button class="button button-primary">Save changes</button>
      </td>
    </tr>

    <tr>
      <td colspan="6">
        <div class="aler alert-warning">Your settings are changed. Save your changes</div>
      </td>
    </tr>
</table>


<?php
}

//save custom fields to option mg_wc_cfmb
function mood_ctcf_custom_fields_save(){
  $value = get_option('mg_wc_cfmb');
  $options = [];
  if ( is_array($_POST) ){
    foreach (array_keys($_POST) as $field){
      if ( strpos($field,'name_') > -1 ){
        $name = str_replace('name_','',$field);
        $a = array (
          'name'    => $name,
          'label'   => sanitize_text_field($_POST['label_'.$name]),
          'active'  => sanitize_text_field($_POST['active_'.$name]) == 'on' ? '1':'0',
          'tab_description' => sanitize_text_field($_POST['tab_description_'.$name]) == 'on' ? '1':'0',
          'meta'    => sanitize_text_field($_POST['meta_'.$name]) == 'on' ? '1' : '0',
          'tab'     => sanitize_text_field($_POST['tab_'.$name])
        );
        array_push($options,$a);

      }
    }
    update_option('mg_wc_cfmb', $options);
    if ( isset($_POST['cfmb_new_field']) &&  strlen($_POST['cfmb_new_field']) > 2 ){
      $name = str_replace(' ','',strtolower(sanitize_text_field($_POST['cfmb_new_field'])));
      $a = array (
          'name'    => $name,
          'label'   => sanitize_text_field($_POST['cfmb_new_field']),
          'active'  => 1,
          'meta'    => 0,
          'tab'     => 'description'
      );
      array_push($options,$a);
      update_option('mg_wc_cfmb', $options);
      $value = $options;
    }
    if ( isset($_POST['mood_ctcf_settings_layout'])){
      $a = array (
        'customfields_layout' => sanitize_text_field($_POST['mood_ctcf_settings_layout']),
      );
      update_option('mood_ctcf_settings',$a);
    }
  }

  return $options;
}


//optimize db
function mood_ctcf_db_optimize(){
  global $wpdb;
  $optimized = false;
  if ( isset($_POST['mg_wc_cfmb_optimize']) && int($_POST['mg_wc_cfmb_optimize']) == 1 ){
    $wpdb->query("DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'mg_cf_%' AND meta_value = ''");
    $optimized = true;
  }
  $optimize = $wpdb->query("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'mg_cf_%' AND meta_value = ''");
  $current = $wpdb->query("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'mg_cf_%'");
  ?>
  <form method="POST">
    <input type="hidden" name="mg_wc_cfmb_optimize" value="1">
    <h1>Product Custom Tabs & Fields for Woocommerce</h1>
    <h3>Database optimization</h3>
    <p>This option checks if your products database has empty custom fields. You can clean all the empty data in order to improve your database performance</p>
    <p>
    You have <?php echo esc_attr($current);?> custom fields.<br>
    You have <?php echo esc_attr($optimize);?> records to optimize.
    </p>
    <?php if ( $optimized ) { ?> <h3>Database optimized!</h3> <?php }?>
    <?php if ( (int)$optimize > 0 ) {
      ?>
      <p style="color:red">WARNING !</p>
      <p>This operation will permanently delete record from your database. We suggest to make a copy before to proceed with the optimization</p>
      <div>
        <?php submit_button('Optimize'); ?>
      </div>
    <?php
    }
  //.end of form
}
