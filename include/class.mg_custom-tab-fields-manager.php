<?php

/* Custom Tabs & Fields for Woocommerce by moodgiver */
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('mg_custom_tab_manager') ):

	class mg_custom_tab_manager {

		public function __construct(){
      add_action( 'init', array( $this, 'mg_custom_tab_post_type' ), 0 );
      add_action( 'init', array ( $this ,'add_product_cat_to_custom_tab_post_type') );
      add_action('admin_menu', array ( $this , 'mg_wc_custom_tab_submenu') );
      add_filter( 'post_row_actions', array( $this, 'mg_remove_tabs_view_option' ), 10, 2 );
      add_action( 'admin_head-post-new.php', array( $this, 'mg_wc_tab_head_extra' ) );
			add_action( 'admin_head-post.php', array( $this, 'mg_wc_tab_head_extra' ) );
      add_action( 'save_post', array( $this, 'mg_wc_tab_save_post' ) );
      add_filter( 'manage_edit-mg_wc_tab_columns', array( $this, 'mg_tabs_edit_columns' ), 10 );
      add_filter( 'manage_mg_wc_tab_posts_custom_column', array( $this, 'mg_wc_tabs_custom_columns' ), 2, 10 );
      //create metabox
      add_action( 'add_meta_boxes', array ( $this , 'mg_wc_tab_add_meta_boxes') );
      add_action( 'add_meta_boxes', array ( $this , 'mg_wc_custom_fields_add_meta_boxes') );

      add_action('woocommerce_process_product_meta', array ( $this,'woocommerce_product_wc_mg_custom_fields_save'),0);
      add_filter( 'woocommerce_product_tabs', array($this, 'woocommerce_product_wc_mg_custom_tabs'), 98 );
      add_action('woocommerce_product_meta_end' , array( $this ,'wc_custom_fields_meta') , 60);
    }


		/* add single page product custom fields to meta */
    public function wc_custom_fields_meta(){
      global $post;
      $options = get_option('mg_wc_cfmb');
      $id = get_the_ID();
      if ( $options ){
      foreach ( $options AS $key=>$value ){
        if ( !$value['custom_tab'] ){
          if ( $value['meta'] == 1 ){
            $label = $value['label'];
            $meta = get_post_meta($post->ID,$key='_cf_'.$value['name']);
            ?>
            <span class=""><?php echo $label;?>: <span><?php echo $meta[0];?></span></span>
            <?php
          }
        }
      }
      }
    }

    //extra head for tab edit page
    public function mg_wc_tab_head_extra(){
      global $post_type;
      $post_types = array( 'mg_wc_tab' );
      if( in_array( $post_type, $post_types ) )

      echo '<script>jQuery(document).ready(function(){
        jQuery("#post,#submitpost").prepend("<div class=\'misc-pub-section\'><span><a href=\'edit.php?post_type=mg_wc_tab\'>Back to Custom Tabs</a></span></div>");
      jQuery("#post-body-content").append(\'<div>This is a header global text for the tab</div>\');});</script>
        <style>#post-preview, #view-post-btn{display: none;}</style>';

    }

    //save post meta
    public function mg_wc_tab_save_post( $post_id ) {
		    $slug = 'mg_wc_tab';
        if ($post->post_type != 'mg_wc_tab'){
          print_r($_POST);
        }

		    if( get_post_type($post_id) !== 'mg_wc_tab' ){
		    	return;
		    }

		    if ( $_POST && $slug !== $_POST['post_type'] ) {
		        return;
		    }

		    if ( !current_user_can( 'edit_post', $post_id ) ) {
		        return;
		    }

        /*
		    $_POST += array("{$slug}_edit_nonce" => '');

		    if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"], plugin_basename( __FILE__ ) ) ) {
		        return;
		    }
        */

		    if ( isset( $_REQUEST['mg_wc_tab_order'] ) ) {
		        update_post_meta( $post_id, 'mg_wc_tab_order', $_REQUEST['mg_wc_tab_order'] );
		    }

        # checkboxes are submitted if checked, absent if not
		    if ( isset( $_REQUEST['mg_wc_tab_active'] ) ) {

		        update_post_meta($post_id, 'mg_wc_tab_active', TRUE);

		    }else {

		        update_post_meta($post_id, 'mg_wc_tab_active', FALSE);

		    }

        if ( isset( $_REQUEST['mg_wc_tab_footer'] ) ) {

		        update_post_meta( $post_id, 'mg_wc_tab_footer', $_REQUEST['mg_wc_tab_footer'] );

		    }

          $custom_fields = get_option('mg_wc_cfmb');
          foreach ( $custom_fields AS $key=>$cf ){
            if ( isset($_REQUEST['mg_wc_tab_custom_field_'.$cf['name']]))
            update_post_meta( $post_id, 'mg_wc_tab_custom_field_' .$cf['name'], TRUE );
          }

		}

    //save product custom fields (postmeta)
    public function woocommerce_product_wc_mg_custom_fields_save($post_id){
      //get attributes
      $options = get_option('mg_wc_cfmb');
      foreach ( $options AS $key=>$value ){
          if ( isset($_POST['_cf_'.$value['name']]) )
          {
            $woocommerce_custom_product_textarea = $_POST['_cf_'.$value['name']];
            if (!empty($woocommerce_custom_product_textarea))
            {
              update_post_meta($post_id, '_cf_'.$value['name'], esc_html($woocommerce_custom_product_textarea));
            }
            else
            {
              delete_post_meta($post_id,'_cf_'.$value['name']);
            }
          }

      }
    }

		//get save tabs
    public function mg_wc_get_tabs(){
  			$args = array (
  				'post_type'      	=>  'mg_wc_tab'  ,
  				'post_status'    	=>  'publish',
  				'posts_per_page' 	=>  -1,
  				'meta_query' 		=> array(
  					array(
  						'key'     => 'mg_wc_tab_active',
  						'value'   => '1',
  					),
  				)
  			);
  			$q_tabs = 	get_posts( $args );
  			$tabs 	=	array();
  			foreach ($q_tabs as $tab){
  				$attr_tab = array();
  				$attr_tab['title']                  	=   $tab->post_title;
  				$attr_tab['priority']               	=   get_post_meta($tab->ID, 'mg_wc_tab_order', true);
          $attr_tab['category']                 =   get_the_terms($tab->ID,'product_cat');
  				$attr_tab['id']                     	=   $tab->ID;
  				$tabs[$tab->post_title.'_'.$tab->ID] 	=   $attr_tab;
  			}

  			return $tabs;

    }

    //create product custom Tabs
    public function woocommerce_product_wc_mg_custom_tabs($tabs){
      global $post;
      $found = $this->woocommerce_product_custom_tab_category($post->ID);
      if ( $found ){
        $mg_wc_tabs = $this->mg_wc_get_tabs();
        foreach ( $mg_wc_tabs as $tab ){

          $tabs[$tab["id"]] = array(
            'title'		=>	__( $tab['title'], 'mg_wc_tab-woocommerce-tab-manager' ),
            'priority' 	=>	$tab['priority'] + 10,
            'callback' 	=>	array ( $this, 'mg_wc_custom_tab_the_content_tabs' )
          );
        }
      }
      return $tabs;
    }

		//search if a tab is assigned to the current product category
    public function woocommerce_product_custom_tab_category($post_id){
      $terms = get_the_terms($post_id,'product_cat');
      $mg_wc_tabs = $this->mg_wc_get_tabs();
      $found = false;
      foreach ( $mg_wc_tabs AS $tab ){
        $categories = $tab['category'];
        foreach ( $categories AS $category ){
          foreach ( $terms AS $k=>$cat ){
            if ( $cat->slug == $category->slug ){
              $found = true;
              break;
            }
          }
        }
      }
      return $found;
    }

		//get the content for the tab
    public function mg_wc_custom_tab_the_content_tabs($id,$tab){
      $content_post 	= get_post($id);
      $footer     = get_post_meta($id,$key='mg_wc_tab_footer');
			$content 		= $content_post->post_content;
			$content 		= apply_filters('the_content', $content);
			//$content 		= str_replace(']]>', ']]&gt;', $content);
      $custom_fields = $this->mg_wc_custom_tab_get_custom_fields($id);
      $copyright  = '<p><small>Custom Tab created with Custom Tabs&Fields for Woocomerce - &copy;-'.date('Y').'</small></p>';
			echo $content.$custom_fields.$footer[0].$copyright;
    }

		//return custom fields meta data for the current product
    public function mg_wc_custom_tab_get_custom_fields($id){
      global $post;
      $fields = get_option('mg_wc_cfmb');
      ?>

      <?php
      $row = '<table class="shop_attributes">';
      foreach ( $fields AS $field ){

        if ( get_post_meta($id,$key='mg_wc_tab_custom_field_'.$field['name'])){
          $custom_field = get_post_meta(get_the_ID(),'_cf_'.$field['name']);
          if ( strlen($custom_field[0]) > 0){
          $row .= '
          <tr>
            <th>'.$field['label'].'</th>
            <td>'.htmlspecialchars_decode($custom_field[0]).'</td>
          </tr>';
          }
        }
      }
      return $row.'</table>';
    }

		//create tab post type
    public function mg_custom_tab_post_type(){
    			$labels = array(
  				'name'                  => _x( 'Custom Tabs for Woocommerce', 'Post Type General Name', 'mg_custom_tab_manager' ),
  				'singular_name'         => _x( 'Tab', 'Post Type Singular Name', 'mg_custom_tab_manager' ),
  				'menu_name'             => __( 'Custom Tab', 'mg_custom_tab_manager' ),
  				'name_admin_bar'        => __( 'Custom Tab', 'mg_custom_tab_manager' ),
  				'archives'              => __( 'Tab Archives', 'mg_custom_tab_manager' ),
  				'parent_item_colon'     => __( 'Parent Tab:', 'mg_custom_tab_manager' ),
  				'all_items'             => __( 'All Tabs', 'mg_custom_tab_manager' ),
  				'add_new_item'          => __( 'Add New Tab', 'mg_custom_tab_manager' ),
  				'add_new'               => __( 'Add New Tab', 'mg_custom_tab_manager' ),
  				'new_item'              => __( 'New Tab', 'mg_custom_tab_manager' ),
  				'edit_item'             => __( 'Edit Tab', 'mg_custom_tab_manager' ),
  				'update_item'           => __( 'Update Tab', 'mg_custom_tab_manager' ),
  				'view_item'             => __( 'View Tab', 'mg_custom_tab_manager' ),
  				'search_items'          => __( 'Search Tab', 'mg_custom_tab_manager' ),
  				'not_found'             => __( 'Not found', 'mg_custom_tab_manager' ),
  				'not_found_in_trash'    => __( 'Not found in Trash', 'mg_custom_tab_manager' ),
  				'insert_into_item'      => __( 'Insert into tab', 'mg_custom_tab_manager' ),
  				'uploaded_to_this_item' => __( 'Uploaded to this tab', 'mg_custom_tab_manager' ),
  				'items_list'            => __( 'Tabs list', 'mg_custom_tab_manager' ),
  				'items_list_navigation' => __( 'Tabs list navigation', 'mg_custom_tab_manager' ),
  				'filter_items_list'     => __( 'Filter tabs list', 'mg_custom_tab_manager' ),
  			);
  			$args = array(
  				'label'                 => __( 'Tab', 'mg_custom_tab_manager' ),
  				'description'           => __( 'Custom Tab Post Type for Woocommerce', 'mg_custom_tab_manager' ),
  				'labels'                => $labels,
  				'supports'              => array( 'title', 'editor', ),
  				'hierarchical'          => false,
  				'public'                => false,
  				'show_ui'               => true,
  				'show_in_menu'          => false,
  				'menu_position'         => 80,
  				'menu_icon'             => 'dashicons-screenoptions',
  				'show_in_admin_bar'     => false,
  				'show_in_nav_menus'     => false,
  				'can_export'            => true,
  				'has_archive'           => false,
  				'exclude_from_search'   => true,
  				'publicly_queryable'    => true,
  				'capability_type'       => 'page',
  			);
  			register_post_type( 'mg_wc_tab', $args );
    }

    //remove view option from the admin screen tab edit
    public	function mg_remove_tabs_view_option( $actions, $post ){
      if( $post->post_type == 'mg_wc_tab' ){
  		  unset( $actions['view'] );
  		}
  		return $actions;
    }

    //columns for tabs list page
    public function mg_tabs_edit_columns($columns){
      $columns = array(
				'cb' 			=> '<input type="checkbox" />',
				'title' 		=> __( 'Custom Tab Name', 'mg-custom-tabs-manager' ),
        'cf'        => __( 'Custom Fields' , 'mg-custom-tabs-manager'),
				'order' 		=> __( 'Order', 'mg-custom-tabs-manager' ),
				'visibility' 	=> __( 'Tab Visibility', 'mg-custom-tabs-manager' ),
				'date' 			=> __( 'Date', 'mg-custom-tabs-manager' ),
			);
			return $columns;
    }

		//create custom columns for the admin screen tab page
    public function mg_wc_tabs_custom_columns ( $column, $post_id ) {
			global $post;
      $custom_fields = get_option('mg_wc_cfmb');
			switch( $column ) {
        case 'cf':
          $fields = '<small>';
          foreach ( $custom_fields AS $cf ){
            if ( get_post_meta($post_id,'mg_wc_tab_custom_field_'.$cf['name']) ){
              $fields .= $cf['label'].', ';
            }
          }
          echo rtrim($fields,', ').'</small>';
          break;

				case 'order' :
					$order = get_post_meta( $post_id, 'mg_wc_tab_order', true );
				  if ( !empty( $order ) )
						printf( __( '%s' ), $order );
					break;

				case 'visibility' :
					$visibility = get_post_meta( $post_id, 'mg_wc_tab_active', true );
					if ( !empty( $visibility ) ) {
            echo 'Visible';
					}else {
            echo 'Hidden';
					}
					break;

        default :
					break;
			}
		}

		//add settings metabox for the custom tab admin edit page
		//@order > define the tab position
		//@active > tab is active (display enabled)
    public function mg_wc_tab_add_meta_boxes(){
      add_meta_box(
       'custom_meta_box-mg_wc_tab',       // $id
       'Settings',                        // $title
       'show_custom_meta_box_mg_wc_tab',  // $callback
       'mg_wc_tab',                       // $page
       'normal',                          // $context
       'high'                             // $priority
      );

      add_meta_box(
       'custom_meta_box-mg_wc_tab_fields',       // $id
       'Tab Custom Fields to include',                        // $title
       'show_custom_meta_box_mg_wc_tab_fields',  // $callback
       'mg_wc_tab',                       // $page
       'side',                            // $context
       'default'                             // $priority
      );

    }

		//add custom fields metabox assignable to the current tab (admin edit screen)
    function mg_wc_custom_fields_add_meta_boxes(){
      add_meta_box(
       'custom_meta_box-mg_wc_custom_fields',       // $id
       'Custom Fields',                             // $title
       'show_product_meta_box_mg_wc_custom_fields',  // $callback
       'product',                         // $page
       'normal',                          // $context
       'default'                             // $priority
      );
    }

    //add category metabox to tabs editor
    public function add_product_cat_to_custom_tab_post_type() {
        register_taxonomy_for_object_type( 'product_cat', 'mg_wc_tab' );
    }

    //Create Plugin admin menu
    public function mg_wc_custom_tab_submenu(){
			//Main menu
      add_menu_page(
        'Products Custom Tabs & Fields',
        'Products Custom Tabs & Fields',
        'manage_options',
        'mg_wc_ctcf',
        'mg_wc_ctcf_main',
        'dashicons-welcome-widgets-menus' );

			//custom tab menu
      add_submenu_page(
        'mg_wc_ctcf',
        'Custom Tabs',
        'Custom Tabs',
        'manage_options',
        'edit.php?post_type=mg_wc_tab',
        NULL
      );

			//custom fields menu
      add_submenu_page(
        'mg_wc_ctcf',
        'Custom Fields',
        'Custom Fields',
        'manage_options',
        'menu-posts-mg_wc_custom_fields',
        'mg_custom_fields'
      );

			//DB Optimize
			add_submenu_page(
				'mg_wc_ctcf',
        'DB Optimize',
        'DB Optimize',
        'manage_options',
        'menu-posts-mg_wc_db_optimize',
        'mg_db_optimize'
			);
    }
  }

endif;
new mg_custom_tab_manager();