<?php
// Start Modification Columns
add_filter("manage_edit-pricing-tables_columns", "phc_pricing_tables_edit_columns");
function phc_pricing_tables_edit_columns($columns){
	$columns= array(
	"cb"=>"<input type=\"checkbox\" />",
	"title"=>_x("Title", "column", PHC_PRICING_TABLE_IDENTIFIER),
	"shortcode"=>_x("Shortcode", "column", PHC_PRICING_TABLE_IDENTIFIER),
	"plan"=>_x("Plan", "column", PHC_PRICING_TABLE_IDENTIFIER),
	"author"=>_x("Author", "column", PHC_PRICING_TABLE_IDENTIFIER),
	"date"=>_x("Date", "column", PHC_PRICING_TABLE_IDENTIFIER),
	);
	
	return $columns;
}

add_action("manage_pricing-tables_posts_custom_column", 
"phc_pricing_tables_custom_columns");
function phc_pricing_tables_custom_columns($columns){
	global $post;
	$custom= get_post_custom();
	$theme= ( isset($custom["theme"][0]) ) ? json_decode($custom["theme"][0], TRUE) : "default";
	switch( $columns ){
		case "plan":
			$title= isset($custom['title'][0]) ? json_decode($custom['title'][0], TRUE) : "";
			if( !empty($title) ){
				foreach( $title as $item ){
					echo $item . "<br/>";
				}
			}
			break;
		case "shortcode":
			echo '<code>[phc_pricing_tables id="' . $post->ID . '" theme="' . $theme . '"]</code>';
			break;
	}
}
// End Modification Columns
?>