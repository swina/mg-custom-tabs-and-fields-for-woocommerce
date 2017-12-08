<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;



function mg_ctcf_custom_fields_manager(){
  if ( isset($_POST['mg_ctcf_save']) ){
    $values = mg_ctcf_custom_fields_save();
  } else {
    $values = get_option('mg_wc_cfmb');
  }

  ?>
<h1>Custom Fields for Woocommerce</h1>
<form method="POST" id="cfmb_form">
<table class="wp-list-table widefat fixed striped tags ui-sortable custom-fields-table">
  <tr>
    <td colspan="6">
      <div class="aler alert-warning" style="width:100%;background:#ffc377;padding:10px;border:2px solid #db7e0a;display:none">You settings are changed. Save your changes</div>
    </td>
  </tr>
  <tr>
    <th colspan="6">
      <h3>Custom Fields</h3>
    </th>
  </tr>
  <tr class="table-options-row">
    <th>Field Label</th>
    <th>Slug</th>
    <th>Enabled</th>

    <th>Product Page Meta</th>
    <th></th>
    <th></th>
  </tr>
  <tbody class="ui-sortable field_rows">
  <input type="hidden" name="mg_ctcf_save" value="1">

<?php
    if ( $values ){
    foreach ( $values AS $key=>$v ){
      if ( isset($v['name']) ){
        ?>
        <tr id="row_<?php echo $v['name'];?>" class="field_row">
          <td>
            <input type="hidden" name="name_<?php echo $v['name'];?>" value="<?php echo $v['name'];?>">
            <input type="text" name="label_<?php echo $v['name'];?>" value="<?php echo $v['label'];?>">
          </td>
          <td>
            <?php echo $v['name'];?>
          </td>
          <td>
            <input type="checkbox" name="active_<?php echo $v['name']?>"  <?php echo esc_attr( $v['active'] ) == '1' ? 'checked="checked"' : ''; ?>>
          </td>

          <td>
            <input type="checkbox" name="meta_<?php echo $v['name']?>"  <?php echo esc_attr( $v['meta'] ) == '1' ? 'checked="checked"' : ''; ?>>
          </td>
          <td>
            <a href="#" class="btn_delete" data-field="<?php echo $v['name'];?>"><span class="dashicons dashicons-trash"></span></a>
          </td>
          <td><span class="dashicons dashicons-menu"></span></td>
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
    <tr class="hide">
      <td colspan="6">
        <h3>Custom Fields Position</h3>
      </td>
    </tr>

    <tr class="hide">
      <td colspan="6" class="left">
        <strong>Tab name</strong>
        <input type="text" placeholder="description" name="custom_tab_name" value="<?php echo esc_attr($custom_tab['tab_name']); ?>" size="50" /> <small>Assign a new name to the description tab or to the new tab</small>
      </td>
    </tr>
    <tr class="hide">
      <td colspan="6" class="left">
        <input type="checkbox" name="custom_tab_description" <?php echo  esc_attr($custom_tab['active']) == '1' ? 'checked="checked"' : '';?>> <strong>Add to description tab</strong>
      </td>
    </tr>
    <tr>
      <td colspan="6">
        <div class="aler alert-warning" style="width:100%;background:#ffc377;padding:10px;border:2px solid #db7e0a;display:none">Your settings are changed. Save your changes</div>
      </td>
    </tr>
</table>


<?php
}

function mg_ctcf_custom_fields_save(){
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
  }
  return $options;
}

function mg_db_optimize(){
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
