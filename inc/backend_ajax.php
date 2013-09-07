<?php
// Enqueue the script, in the footer
add_action('admin_print_scripts-post.php', 'phc_pricing_table_js');
add_action('admin_print_scripts-post-new.php', 'phc_pricing_table_js');
function pch_bpt_wim_media_admin_scripts(){
	wp_enqueue_media();
	wp_enqueue_script('pch_meta_image_js', plugins_url("js/meta-image.js", __FILE__));
}
function phc_pricing_table_js() {
    global $post;
	
	wp_enqueue_script('jquery_blockUI', PHC_PRICING_TABLE_PATH_URL . "js/jquery.blockUI.js");
	wp_enqueue_script(PHC_PRICING_TABLE_ID_SCRIPT . '_admin_js', PHC_PRICING_TABLE_PATH_URL . "js/admin.js", array("jquery-ui-core", "jquery-ui-accordion", "jquery-ui-sortable"));
	
	// Get current page protocol
	$protocol = isset( $_SERVER['HTTPS']) ? 'https://' : 'http://';
	// Output admin-ajax.php URL with same protocol as current page
	$params = array(
	'ajaxurl'=>admin_url('admin-ajax.php', $protocol),
	'loading_text'=>'<h1>Loading...</h1>',
	'feedback_selector'=>'#pch-bpt-wim-post-html',
	'theme_url'=>PHC_PRICING_TABLE_THEME_URL,
	);
	wp_localize_script(PHC_PRICING_TABLE_ID_SCRIPT . '_admin_js', PHC_PRICING_TABLE_ID_SCRIPT . 
	'_admin_js_params', $params);
}

// Ajax handler
add_action('wp_ajax_phc_pricing_table_ajax', 'phc_pricing_table_ajax');
function phc_pricing_table_ajax(){
	global $post;
	extract($_POST);
	
	$custom= get_post_meta($post_id);
	$button_url_type_curr= isset($custom['button_url_type'][0]) ? json_decode($custom['button_url_type'][0], TRUE) : 
	"";
	
	$button_url= "";
	$button_url_curr= "";
	if( isset($button_url_type_curr[$current_plan_id]) && 
	$button_url_type_curr[$current_plan_id] == $button_url_type ){
	$button_url= ( isset($custom['button_url'][0]) ) ? json_decode($custom['button_url'][0], TRUE) : "";
	$button_url_curr= ( isset($button_url[$current_plan_id]) ) ? $button_url[$current_plan_id] : "";
	}
	
	$args= array(
	'post_type'=>'post',
	'posts_per_page'=>-1
	);
	$posts_dt= new WP_Query($args);
	$posts= $posts_dt->get_posts();
	wp_reset_postdata();
	
	$args= array(
	'post_type'=>'page',
	'posts_per_page'=>-1
	);
	$pages_dt= new WP_Query($args);
	$pages= $pages_dt->get_posts();
	wp_reset_postdata();

	ob_start();
	switch ($button_url_type){
		case "custom_url":
	?>
	<div class="button_url">
	<label>&nbsp;</label>
	<input id="button_url[]" type="text" name="button_url[]" 
	value="<?php echo $button_url_curr; ?>" data-type="custom_url" />	
	</div>		
	<?php
		break;
		case "post":
	?>
	<div class="button_url">
	<label>&nbsp;</label>
	<select name="button_url[]" data-type="post">
	<?php
	foreach( $posts as $item ){
		$selected= "";
		if( $item->ID == $button_url[$current_plan_id] ){
			$selected= " selected=\"selected\"";
		}
	?>
	<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
	<?php echo $item->post_title; ?></option>
	<?php
	}
	?>
	</select>
	</div>
	<?php
		break;
		case "page":
	?>
	<div class="button_url">
	<label>&nbsp;</label>
	<select name="button_url[]" data-type="page">
	<?php
	foreach( $pages as $item ){
		$selected= "";
		if( $item->ID == $button_url[$current_plan_id] ){
			$selected= " selected=\"selected\"";
		}
	?>
	<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
	<?php echo $item->post_title; ?></option>
	<?php
	}
	?>
	</select>
	</div>
	<?php
		break;
	}
	$html = ob_get_contents();
	ob_clean();
	
	$res= array('type'=>'html', 'html'=>$html);
	
	// Output Data
	echo json_encode($res);
	exit;
}
?>