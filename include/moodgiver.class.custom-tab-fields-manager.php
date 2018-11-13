<?php

/* Custom Tabs & Fields for Woocommerce by moodgiver */
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('mood_ctcf_custom_tab_manager') ):

	//plugin master class
	class mood_ctcf_custom_tab_manager {

		public function __construct(){
			//actions & filters
      add_action( 'init', array( $this, 'mood_ctcf_custom_tab_post_type' ), 0 );
      add_action( 'init', array ( $this ,'mood_ctcf_add_product_cat_to_custom_tab_post_type') );
      add_action('admin_menu', array ( $this , 'mood_ctcf_custom_tab_submenu') );
      add_filter( 'post_row_actions', array( $this, 'mood_ctcf_remove_tabs_view_option' ), 10, 2 );
      add_action( 'admin_head-post-new.php', array( $this, 'mood_ctcf_tab_head_extra' ) );
			add_action( 'save_post', array( $this, 'mood_ctcf_tab_save_post' ) );
			add_action( 'admin_head-post.php', array( $this, 'mood_ctcf_tab_head_extra' ) );
			add_filter( 'manage_edit-mg_wc_tab_columns', array( $this, 'mood_tabs_edit_columns' ), 10 );
      add_filter( 'manage_mg_wc_tab_posts_custom_column', array( $this, 'mood_wc_tabs_custom_columns' ), 2, 10 );
      add_action( 'add_meta_boxes', array ( $this , 'mood_ctcf_tab_add_meta_boxes') );
      add_action( 'add_meta_boxes', array ( $this , 'mood_ctcf_custom_fields_add_meta_boxes') );

      add_action('woocommerce_process_product_meta', array ( $this,'mood_ctcf_custom_fields_save'),0);
      add_filter( 'woocommerce_product_tabs', array($this, 'mood_ctcf_custom_tabs'), 98 );
			add_filter( 'woocommerce_product_tabs', array ($this,'mood_ctcf_custom_description_tab'), 99 );
      add_action('woocommerce_product_meta_end' , array( $this ,'mood_ctcf_custom_fields_meta') , 60);
    }


		/*-------------- ADMIN FUNCTIONS -----------------*/
		/*
		/*-------------------------------------------------*/
		//Create Plugin admin menu
    public function mood_ctcf_custom_tab_submenu(){
      add_menu_page(
        'Dashboard',
        'Moodgiver Custom Tabs & Fields',
        'manage_options',
        'mg_wc_ctcf',
        'mg_wc_ctcf_main',
        'dashicons-welcome-widgets-menus' );


			//custom fields menu
      add_submenu_page(
        'mg_wc_ctcf',
        'Custom Fields',
        'Custom Fields',
        'manage_options',
        'menu-posts-mg_wc_custom_fields',
        'mood_ctcf_custom_fields'
      );

			//custom tab menu
      add_submenu_page(
        'mg_wc_ctcf',
        'Custom Tabs',
        'Custom Tabs',
        'manage_options',
        'edit.php?post_type=mg_wc_tab',
        NULL
      );

			//DB Optimize
			add_submenu_page(
				'mg_wc_ctcf',
        'DB Optimize',
        'DB Optimize',
        'manage_options',
        'menu-posts-mg_wc_db_optimize',
        'mood_ctcf_db_optimize'
			);

			//CSV Data Sample
			add_submenu_page(
				'mg_wc_ctcf',
        'CSV Data Sample',
        'CSV Data Sample',
        'manage_options',
        'menu-posts-mg_wc_csv_sample',
        'mood_ctcf_create_sample_csv'
			);


    }

		//create tab post type
    public function mood_ctcf_custom_tab_post_type(){
    			$labels = array(
  				'name'                  => _x( 'Custom Tabs for Woocommerce', 'Post Type General Name', 'mood_ctcf' ),
  				'singular_name'         => _x( 'Tab', 'Post Type Singular Name', 'mood_ctcf' ),
  				'menu_name'             => __( 'Custom Tab', 'mood_ctcf' ),
  				'name_admin_bar'        => __( 'Custom Tab', 'mood_ctcf' ),
  				'archives'              => __( 'Tab Archives', 'mood_ctcf' ),
  				'parent_item_colon'     => __( 'Parent Tab:', 'mood_ctcf' ),
  				'all_items'             => __( 'All Tabs', 'mood_ctcf' ),
  				'add_new_item'          => __( 'Add New Tab', 'mood_ctcf' ),
  				'add_new'               => __( 'Add New Tab', 'mood_ctcf' ),
  				'new_item'              => __( 'New Tab', 'mood_ctcf' ),
  				'edit_item'             => __( 'Edit Tab', 'mood_ctcf' ),
  				'update_item'           => __( 'Update Tab', 'mood_ctcf' ),
  				'view_item'             => __( 'View Tab', 'mood_ctcf' ),
  				'search_items'          => __( 'Search Tab', 'mood_ctcf' ),
  				'not_found'             => __( 'Not found', 'mood_ctcf' ),
  				'not_found_in_trash'    => __( 'Not found in Trash', 'mood_ctcf' ),
  				'insert_into_item'      => __( 'Insert into tab', 'mood_ctcf' ),
  				'uploaded_to_this_item' => __( 'Uploaded to this tab', 'mood_ctcf' ),
  				'items_list'            => __( 'Tabs list', 'mood_ctcf' ),
  				'items_list_navigation' => __( 'Tabs list navigation', 'mood_ctcf' ),
  				'filter_items_list'     => __( 'Filter tabs list', 'mood_ctcf' ),
  			);
  			$args = array(
  				'label'                 => __( 'Tab', 'mood_ctcf' ),
  				'description'           => __( 'Custom Tab Post Type for Woocommerce', 'mood_ctcf' ),
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

    //extra head for tab edit page
    public function mood_ctcf_tab_head_extra(){
      global $post_type;
      $post_types = array( 'mg_wc_tab' );
      if( in_array( $post_type, $post_types ) )

      echo '<script>jQuery(document).ready(function(){
        jQuery("#post,#submitpost").prepend("<div class=\'misc-pub-section\'><span><a href=\'edit.php?post_type=mg_wc_tab\'>Back</a></span></div>");
      jQuery("#post-body-content").append(\'<div>Global Header</div>\');});</script>
      <style>#post-preview, #view-post-btn{display: none;}</style>';

    }

    //save post meta
    public function mood_ctcf_tab_save_post( $post_id ) {
		  $slug = 'mg_wc_tab';
				if( get_post_type($post_id) !== 'mg_wc_tab' ){
		    	return;
		    }

		    if ( !current_user_can( 'edit_post', $post_id ) ) {
		        return;
		    }

		    if ( isset( $_REQUEST['mg_wc_tab_order'] ) ) {
		        update_post_meta( $post_id, 'mg_wc_tab_order', $_REQUEST['mg_wc_tab_order'] );
		    }

        # checkboxes are submitted if checked, absent if not
		    if ( isset( $_REQUEST['mg_wc_tab_active'] ) ) {
						print_r('<h1>' . $post_id .'</h1>');

		        update_post_meta($post_id, 'mg_wc_tab_active', TRUE);
		    } else {
		        update_post_meta($post_id, 'mg_wc_tab_active', FALSE);
		    }

        if ( isset( $_REQUEST['mg_wc_tab_footer'] ) ) {
		        update_post_meta( $post_id, 'mg_wc_tab_footer', $_REQUEST['mg_wc_tab_footer'] );
		    }

        $custom_fields = get_option('mg_wc_cfmb');
				if ( $custom_fields ){
        	foreach ( $custom_fields AS $key=>$cf ){
            if ( isset($_REQUEST['mg_wc_tab_custom_field_'.$cf['name']])) {
            	update_post_meta( $post_id, 'mg_wc_tab_custom_field_' .$cf['name'], TRUE );
						} else {
							delete_post_meta( $post_id, 'mg_wc_tab_custom_field_' .$cf['name'] );
						}
          }
				}
		}

		//get saved tabs
    public function mood_ctcf_get_tabs(){
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

    //remove view option from the admin screen tab edit
    public	function mood_ctcf_remove_tabs_view_option( $actions, $post ){
      if( $post->post_type == 'mg_wc_tab' ){
  		  unset( $actions['view'] );
				unset( $actions['inline hide-if-no-js']);
  		}
  		return $actions;
    }

    //columns for tabs list page
    public function mood_tabs_edit_columns($columns){
      $columns = array(
				'cb' 			=> '<input type="checkbox" />',
				'title' 		=> __( 'Custom Tab Name', 'mood_ctcf' ),
        'cf'        => __( 'Custom Fields' , 'mood_ctcf'),
				'order' 		=> __( 'Order', 'mood_ctcf' ),
				'visibility' 	=> __( 'Tab Visibility', 'mood_ctcf' ),
				'date' 			=> __( 'Date', 'mood_ctcf' ),
			);
			return $columns;
    }

		//create custom columns for the admin screen tab page
    public function mood_wc_tabs_custom_columns ( $column, $post_id ) {
			global $post;
      $custom_fields = get_option('mg_wc_cfmb');
			if ( $custom_fields ){
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
            _e('Visible','mood_ctcf');
					}else {
            _e('Hidden','mood_ctcf');
					}
					break;

        default :
					break;
			}
			}
		}

		//add settings metabox for the custom tab admin edit page
		//@order > define the tab position
		//@active > tab is active (display enabled)
    public function mood_ctcf_tab_add_meta_boxes(){
      add_meta_box(
       'custom_meta_box-mg_wc_tab',       // $id
       'Settings',                        // $title
       'mood_ctcf_show_custom_meta_box_mg_wc_tab',  // $callback
       'mg_wc_tab',                       // $page
       'normal',                          // $context
       'high'                             // $priority
      );

      add_meta_box(
       'custom_meta_box-mg_wc_tab_fields',       // $id
       'Custom Fields',                        // $title
       'mood_ctcf_show_custom_meta_box_mg_wc_tab_fields',  // $callback
       'mg_wc_tab',                       // $page
       'side',                            // $context
       'default'                             // $priority
      );

    }

		//add custom fields metabox assignable to the current tab (admin edit screen)
    function mood_ctcf_custom_fields_add_meta_boxes(){
      add_meta_box(
       'custom_meta_box-mg_wc_custom_fields',       // $id
       'Custom Fields',                             // $title
       'mood_ctcf_show_product_meta_box_mg_wc_custom_fields',  // $callback
       'product',                         // $page
       'normal',                          // $context
       'default'                             // $priority
      );
    }

    //add category metabox to tabs editor
    public function mood_ctcf_add_product_cat_to_custom_tab_post_type() {
        register_taxonomy_for_object_type( 'product_cat', 'mg_wc_tab' );
    }

		//save product custom fields (postmeta)
    public function mood_ctcf_custom_fields_save($post_id){
      //get attributes
      $options = get_option('mg_wc_cfmb');
      foreach ( $options AS $key=>$value ){
          if ( isset($_POST['mg_cf_'.$value['name']]) )
          {
            $woocommerce_custom_product_textarea = sanitize_text_field($_POST['mg_cf_'.$value['name']]);
            if (!empty($woocommerce_custom_product_textarea))
            {
              update_post_meta($post_id, 'mg_cf_'.$value['name'], esc_html($woocommerce_custom_product_textarea));
            }
            else
            {
              delete_post_meta($post_id,'mg_cf_'.$value['name']);
            }
          }

      }
    }


		/* ---------------- FRONT END -----------------------
		/*
		/*----------------------------------------------------

		/* append single page product meta custom fields    */
    public function mood_ctcf_custom_fields_meta(){
      global $post;
			//get custom fields
      $options = get_option('mg_wc_cfmb');
      $id = get_the_ID();

			//check if there are custom fields defined
			if ( $options ){

				//loop thru each custom field
				foreach ( $options AS $key=>$value ){

					//check if product meta tag is active
          if ( $value['meta'] == 1 ){

						//append custom field label & value to product meta
          	$label = $value['label'];
            $meta = get_post_meta($post->ID,$key='mg_cf_'.$value['name']);
            ?>
            <div class="mg_cf_meta"><?php echo esc_attr($label);?>: <span><?php echo htmlspecialchars_decode(esc_attr($meta[0]));?></span></div>

				  <?php
          }

				}

			}

		}
		/*.mood_ctcf_custom_fields_meta */

    //create product custom Tabs
    public function mood_ctcf_custom_tabs($tabs){
      global $post;
			$found = $this->woocommerce_product_custom_tab_category($post->ID);
      if ( $found ){
        $mg_wc_tabs = $this->mood_ctcf_get_tabs();
        foreach ( $mg_wc_tabs as $tab ){

          $tabs[$tab["id"]] = array(
            'title'		=>	__( $tab['title'], 'mg_wc_tab-woocommerce-tab-manager' ),
            'priority' 	=>	$tab['priority'] + 10,
            'callback' 	=>	array ( $this, 'mood_wc_custom_tab_the_content_tabs' )
          );
        }
      }
			return $tabs;
    }
		/*.mood_ctcf_custom_tabs*/

		//recreate description tab
		public function mood_ctcf_custom_description_tab($tabs){
			if ( $tabs['description'] ){
				$tabs['description']['callback'] = array ( $this ,'mood_ctcf_custom_description_tab_content');
			}
    	return $tabs;
		}
		/*.mood_ctcf_custom_description_tab*/

		//recreate description tab content
		public function mood_ctcf_custom_description_tab_content(){
			global $post;
			$content 	= $post->post_content;
			$content 	= apply_filters('the_content', $content);
			$custom_fields = $this->mood_ctcf_custom_tab_get_custom_fields_for_description();
			echo $content.$custom_fields;
		}
		/*.mood_ctcf_custom_description_tab_content*/

		//display custom fields assigned to description tab
		public function mood_ctcf_custom_tab_get_custom_fields_for_description(){
			$fields = get_option('mg_wc_cfmb');
			$settings = get_option('mood_ctcf_settings');
			$layout = $settings['customfields_layout'];
			$description_fields = [];
			$row = '';
			if ( $fields ){
				$row = '<table class="shop_attributes">';
				$endrow = '</table>';
				if ( $layout != 'table' ){
					$row = '<div class="mood_custom_fields_wrap">';
					$endrow = '</div>';
				}
				foreach ( $fields AS $field ){
					if ( $field['tab_description'] ){

							$custom_field = get_post_meta(get_the_ID(),'mg_cf_'.$field['name']);
							if ( strlen($custom_field[0]) > 0){
								if ( $layout == 'table' ){
									$row .= '
										<tr>
										<th>'.$field['label'].'</th>
										<td>'.htmlspecialchars_decode($custom_field[0]).'</td>
									</tr>';
								} else {
									$row .= '<div><h2 class="mood_custom_field_label">'.$field['label'].'</h2>';
									$row .= '<p>'.htmlspecialchars_decode($custom_field[0]).'</p></div>';
								}

							}
					}
				}
				return $row . $endrow;
			}
			return $row;
		}
		/*.mood_ctcf_custom_tab_get_custom_fields_for_description*/

		//search if a tab is assigned to the current product category
    public function woocommerce_product_custom_tab_category($post_id){
			$terms = get_the_terms($post_id,'product_cat');
      $mg_wc_tabs = $this->mood_ctcf_get_tabs();
      $found = false;
      foreach ( $mg_wc_tabs AS $tab ){
				$category = $tab['category'];
				foreach ( $category AS $mycat ){
          foreach ( $terms AS $k=>$cat ){
            if ( $cat->term_id == $mycat->term_id ){
              $found = true;
              break;
            }
          }
        }
      }
      return $found;
    }

		//get the content for the tab
    public function mood_wc_custom_tab_the_content_tabs($id,$tab){
      $content_post 	= get_post($id);
      $footer     = get_post_meta($id,$key='mg_wc_tab_footer');
			$content 		= $content_post->post_content;
			$content 		= apply_filters('the_content', $content);
			//$content 		= str_replace(']]>', ']]&gt;', $content);
      $custom_fields = $this->mood_wc_custom_tab_get_custom_fields($id);
      $copyright  = '<p><small>Custom Tab created with Custom Tabs&Fields for Woocomerce - &copy;-'.date('Y').'</small></p>';
			echo $content.$custom_fields.$footer[0];//.$copyright;
    }

		//return custom fields meta data for the current product
    public function mood_wc_custom_tab_get_custom_fields($id){
      global $post;
      $fields = get_option('mg_wc_cfmb');
			$settings = get_option('mood_ctcf_settings');
			$layout = $settings['customfields_layout'];
      ?>

      <?php
			$row = '<table class="shop_attributes mood_custom_fields_table">';
			$endrow = '</table>';
			if ( $layout != 'table' ){
				$row = '<div class="mood_custom_fields_wrap">';
				$endrow = '</div>';
			}
			if ( $fields ){
      	foreach ( $fields AS $field ){
        	if ( get_post_meta($id,$key='mg_wc_tab_custom_field_'.$field['name'])){
          	$custom_field = get_post_meta(get_the_ID(),'mg_cf_'.$field['name']);
          	if ( strlen($custom_field[0]) > 0){
							if ( $layout == 'table' ){
								$row .= '
									<tr>
									<th>'.$field['label'].'</th>
									<td>'.htmlspecialchars_decode($custom_field[0]).'</td>
								</tr>';
							} else {
								$row .= '<div><h2 class="mood_custom_field_label">'.$field['label'].'</h2>';
								$row .= '<p>'.htmlspecialchars_decode($custom_field[0]).'</p></div>';
							}

          	}
        	}
      	}
			}
      return $row . $endrow;

    }

  }

endif;
new mood_ctcf_custom_tab_manager();
