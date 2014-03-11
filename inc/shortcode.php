<?php
add_shortcode('phc_pricing_tables', 'phc_pricing_tables_display');
function phc_pricing_tables_display($atts, $content=null){
	extract($atts);
	ob_start();
	require(PHC_PRICING_TABLE_INCLUDE_PATH . "/theme.php");
	$html = ob_get_contents();
	ob_clean();
	
	return $html;
}
?>