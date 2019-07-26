<?php
/**
 * @package PesaPal For WooCommerce
 * @subpackage Payments CPT
 * @author Mauko Maunde < hi@mauko.co.ke >
 * @since 0.19.04
 */

// Register Custom Post Type
add_action('init', 'os_custom_post_type', 0);
function os_custom_post_type() {

	$labels = array(
		'name'                  => _x('PesaPal Payments', 'Post Type General Name', 'pesapal'),
		'singular_name'         => _x('Payment', 'Post Type Singular Name', 'pesapal'),
		'menu_name'             => __('PesaPal', 'pesapal'),
		'name_admin_bar'        => __('PesaPal IPN', 'pesapal'),
		'archives'              => __('Item Archives', 'pesapal'),
		'attributes'            => __('Item Attributes', 'pesapal'),
		'parent_item_colon'     => __('Parent Item:', 'pesapal'),
		'all_items'             => __('Payments', 'pesapal'),
		'add_new_item'          => __('Add New Item', 'pesapal'),
		'add_new'               => __('Add New', 'pesapal'),
		'new_item'              => __('New Item', 'pesapal'),
		'edit_item'             => __('Edit Item', 'pesapal'),
		'update_item'           => __('Update Item', 'pesapal'),
		'view_item'             => __('View Item', 'pesapal'),
		'view_items'            => __('View Items', 'pesapal'),
		'search_items'          => __('Search Item', 'pesapal'),
		'not_found'             => __('Not found', 'pesapal'),
		'not_found_in_trash'    => __('Not found in Trash', 'pesapal'),
		'featured_image'        => __('Featured Image', 'pesapal'),
		'set_featured_image'    => __('Set featured image', 'pesapal'),
		'remove_featured_image' => __('Remove featured image', 'pesapal'),
		'use_featured_image'    => __('Use as featured image', 'pesapal'),
		'insert_into_item'      => __('Insert into item', 'pesapal'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'pesapal'),
		'items_list'            => __('Items list', 'pesapal'),
		'items_list_navigation' => __('Items list navigation', 'pesapal'),
		'filter_items_list'     => __('Filter items list', 'pesapal'),
	);
	$args = array(
		'label'                 => __('Payment', 'pesapal'),
		'description'           => __('PesaPal Payments IPN', 'pesapal'),
		'labels'                => $labels,
		'supports'              => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-money',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'    	=> 'post',
		'capabilities'       	=> array('create_posts' => false, 'edit_posts' => true, 'delete_post' => true),
		'map_meta_cap'       	=> true,
	);
	register_post_type('pesapal_ipn', $args);

}

/**
 * A filter to add custom columns and remove built-in
 * columns from the edit.php screen.
 * 
 * @access public
 * @param Array $columns The existing columns
 * @return Array $filtered_columns The filtered columns
 */
add_filter('manage_pesapal_ipn_posts_columns', 'filter_pesapal_payments_table_columns');
function filter_pesapal_payments_table_columns($columns)
{
	$columns['customer'] 		= "Customer";
	$columns['phone'] 			= "Phone";
	$columns['amount'] 			= "Amount";
	$columns['transaction'] 	= "Transaction";
	$columns['created'] 		= "Date";
	unset($columns['title']);
	unset($columns['date']);
	return $columns;
}

/**
 * Render custom column content within edit.php table on event post types.
 * 
 * @access public
 * @param String $column The name of the column being acted upon
 * @return void
 */
add_action('manage_pesapal_ipn_custom_column','pesapal_ipn_table_column_content', 10, 2);
function pesapal_ipn_table_column_content($column_id, $post_id)
{
	switch ($column_id) {
		case 'customer':
		echo ($value = get_post_meta($post_id, '_customer', true)) ? $value : "";
		break;

		case 'phone':
		echo ($value = get_post_meta($post_id, '_phone', true)) ? $value : "N/A";
		break;

		case 'amount':
		echo ($value = get_post_meta($post_id, '_amount', true)) ? $value : "0";
		break;

		case 'transaction':
		echo ($value = get_post_meta($post_id, '_transaction', true)) ? $value : "0";
		break;

		case 'created':
		echo ($value = date('M jS, Y \a\t H:i', strtotime(get_post_meta($post_id, '_created', true)))) ? $value : "N/A";
		break;
	}
}

/**
 * Make custom columns sortable.
 * 
 * @access public
 * @param Array $columns The original columns
 * @return Array $columns The filtered columns
 */
add_filter('manage_edit-pesapal_ipn_sortable_columns', 'pesapal_payments_columns_sortable');
function pesapal_payments_columns_sortable($columns) 
{
	$columns['customer'] 		= "Customer";
	$columns['phone'] 			= "Phone";
	$columns['amount'] 			= "Amount";
	$columns['transaction'] 	= "Transaction";
	$columns['created'] 		= "Date";
	return $columns;
}


/**
 * Remove actions from columns.
 * 
 * @access public
 * @param Array $actions Actions to remove
 */
add_filter('post_row_actions', 'pesapal_remove_row_actions', 10, 1);
function pesapal_remove_row_actions($actions)
{
	if(get_post_type() === 'pesapal_ipn'){
		unset($actions['edit']);
		unset($actions['view']);
		unset($actions['inline hide-if-no-js']);
	}
	
	return $actions;
}