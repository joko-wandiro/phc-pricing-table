<?php
add_action('admin_print_scripts-edit.php', 'phc_pricing_table_admin_print_scripts');
function phc_pricing_table_admin_print_scripts(){
	wp_enqueue_style(PHC_PRICING_TABLE_ID_SCRIPT . '_edit_css', PHC_PRICING_TABLE_PATH_URL_CSS . "edit.css");
}
?>