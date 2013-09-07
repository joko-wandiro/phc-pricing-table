<?php
add_action('init', 'phc_pricing_table_post_type');
// Registers post types. 
function phc_pricing_table_post_type(){
	// Set Up Arguments
	$args= array(
	'public'=>TRUE,
	'exclude_from_search'=>FALSE,
	'publicly_queryable'=>FALSE,
	'show_ui'=>TRUE,
	'query_var'=>PHC_PRICING_TABLE_POST_TYPE,
	'rewrite'=>array(
		'slug'=>PHC_PRICING_TABLE_POST_TYPE,
		'with_front'=>false,
	),
	'supports'=>array(
		'title',
	),
	'menu_icon'=>PHC_PRICING_TABLE_IMG_URL . "icon.png",
	'labels'=>array(
		'name'=>__('Pricing Tables', PHC_PRICING_TABLE_IDENTIFIER),
		'singular_name'=>__('Pricing Table', PHC_PRICING_TABLE_IDENTIFIER),
		'add_new'=>__('Add New Pricing Table', PHC_PRICING_TABLE_IDENTIFIER),
		'add_new_item'=>__('Add New Pricing Table', PHC_PRICING_TABLE_IDENTIFIER),
		'edit_item'=>__('Edit Pricing Table', PHC_PRICING_TABLE_IDENTIFIER),
		'new_item'=>__('New Pricing Table', PHC_PRICING_TABLE_IDENTIFIER),
		'view_item'=>__('View Pricing Table', PHC_PRICING_TABLE_IDENTIFIER),
		'search_items'=>__('Search Pricing Tables', PHC_PRICING_TABLE_IDENTIFIER),
		'not_found'=>__('No Pricing Tables Found', PHC_PRICING_TABLE_IDENTIFIER),
		'not_found_in_trash'=>__('No Pricing Tables Found In Trash', PHC_PRICING_TABLE_IDENTIFIER)
	),
	);
	
	// Register It
	register_post_type(PHC_PRICING_TABLE_POST_TYPE, $args);
}
?>