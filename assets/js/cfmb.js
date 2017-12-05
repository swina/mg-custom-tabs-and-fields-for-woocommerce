/* Custom Tabs & Fields for Woocomerce jQuery functions */


jQuery(document).ready(function(){

  //shows a target element (data-target)
  jQuery('.btn-show').on('click',function(){
    jQuery('.' + jQuery(this).data('target')).removeClass('hide');
  })

  //open the rich text editor to edit the custom field
  jQuery('body').delegate('.btn-editor','click',function(){
    var editor = jQuery(this).data('field')+'-wrap';
    var field = jQuery(this).data('field');
    jQuery('.btn-save-cfmb').attr('data-field',field);
    var editor = tinymce.get('_cf_editor');
    // use your own editor id here
    editor.setContent(jQuery('#' + field + '_textarea' ).val());
  })

  //copy wp_editor content to field textarea
  jQuery('.btn-save-cfmb').on('click',function(){
    var editor = tinymce.get('_cf_editor');
    jQuery('#' + jQuery(this).data('field') + '_textarea').val ( editor.getContent());
    jQuery('#myModal').modal('hide');
  })

  //remove a custom field from the product edit screen metabox
  jQuery('.btn-field-remove-saved').on('click',function(){
    var obj = jQuery(this);
    var target = jQuery('.custom_field_saved_' + obj.data('field') );
    var txt_to_clear = jQuery('#_cf_' + obj.data('field') + '_textarea');
    target.css('display','none');
    jQuery('#_cf_' + obj.data('field') + '_textarea').val('');
  })

  //add a custom field to the product edit screen metabox
  jQuery('body').delegate('.select_cfmb','change',function(){
    var obj = jQuery(this);
    var txt = jQuery('.select_cfmb :selected').text();
    if ( obj.val() != '' ){
      jQuery('.custom_fields').append(
        '\
        <div class="custom_field_'+obj.val()+'"><h3>' + txt + '</h3>\
        <textarea id="_cf_' + obj.val() + '_textarea" name="_cf_' + obj.val() + '" style="width:100%;"></textarea>\
        <span class="btn-editor" data-field="_cf_' + obj.val() + '" data-toggle="modal" data-target="#myModal" style="cursor:pointer;"><span class="dashicons dashicons-edit"></span> Editor</span> \
        <span class="btn-field-remove" data-field="' + obj.val() + '" style="cursor:pointer;">\
        <span class="dashicons dashicons-trash"></span> \
        Remove</span></div>'
      )
      jQuery('option:selected',this).remove();
    }
  })

  //remove a new added custom field in the product edit screen metabox
  jQuery(document).delegate('.btn-field-remove','click',function(){
    var obj = jQuery(this);
    var id = obj.data('field');
    jQuery('.custom_field_' + id).remove();
  })

  //preview the content (html) of the custom field (product edit screen metabox)
  jQuery(document).delegate('.btn-custom-field-preview','click',function(){
    var obj = jQuery(this);
    var id = obj.data('field');
    var txt = jQuery('#_cf_' + id + '_textarea').val();
    console.log ( txt );
    jQuery('.modal-body-cf_preview').html(txt);
    jQuery('#cf_preview_modal').modal('show');
  })

  //sort table rows for the custom fields admin edit screen
  jQuery( "table tbody" ).sortable( {
	update: function( event, ui ) {
    jQuery('.alert-warning').css('display','');
    jQuery(this).children().each(function(index) {
			jQuery(this).find('td').last().attr('ordine',index + 1)
    });
  }
  });

  //remove a row (and custom field) from admin edit screen (Custom Fields)
  jQuery('.btn_delete').on('click',function(){
    jQuery('.alert-warning').css('display','');
    var f = jQuery(this).data('field');
    jQuery('#row_' + f).remove();
  })

  //
  jQuery('.mg_wc_tab_order').on('change',function(){
    jQuery('.order-value').html(jQuery(this).val());
  })
})
