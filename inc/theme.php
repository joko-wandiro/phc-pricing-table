<?php
//$theme= "notableapp";
//$theme= "pyconic";
//$theme= "shopify";
//$theme= "sort";
// Load JS and CSS files related to theme
wp_enqueue_style(PHC_PRICING_TABLE_ID_SCRIPT . '_theme_css', PHC_PRICING_TABLE_THEME_URL . "/" . $theme . 
"/css/theme.css");
wp_enqueue_script(PHC_PRICING_TABLE_ID_SCRIPT . '_theme_js', PHC_PRICING_TABLE_THEME_URL . "/" . $theme . 
"/js/theme.js");

ob_start();
require(PHC_PRICING_TABLE_THEME_PATH . "/" . $theme . "/layout.tpl");
$layout= ob_get_contents();
ob_clean();

$sanitize_layout_pattern= "/[\t\n\r]+/";
$replacement= "";
$layout= preg_replace($sanitize_layout_pattern, $replacement, $layout);

$pattern_loop = '#{loop}(?P<li><li>.*</li>){/loop}#';
preg_match_all($pattern_loop, $layout, $matches_elem, PREG_PATTERN_ORDER);
$feature_tpl= $matches_elem['li'][0];

$args= array(
'post_type'=>PHC_PRICING_TABLE_POST_TYPE,
'p'=>$id
);
$query= new WP_Query($args);
?>
<?php
while( $query->have_posts() ){
	$query->the_post();
	$post= get_post();
	$custom= get_post_custom($post->ID);

	$meta_fields= array("plan_id", "title", "detail", "currency", "price", "price_per", 
	"button_url_type", "button_url", "button_text", "feature_description", "set_feature", "theme");
	$datas= array();
	foreach( $meta_fields as $field ){
		if( isset($custom[$field][0]) ){
		$$field= json_decode($custom[$field][0], TRUE);
		}
	}
	
	$num_section= isset($title) ? count($title) : "";
	$li_width= ((100 / (int)$num_section) - 10.2) . "%";
	
	if( !empty($num_section) ){
?>
<ul id="pricing-table-plan-<?php echo $id; ?>" class="phc-pricing-table">
<?php
	for( $ct=0; $ct<$num_section; $ct++ ){
		$feature_id= $plan_id[$ct];
		$feature_class= "";
		if( $feature_id == $set_feature ){
			$feature_class= "feature";
		}

		$html= "";
		$html= $layout;
		switch ($button_url_type[$ct]){
			case "post":
				$post_dt= get_post($button_url[$ct]);
				$button_url[$ct]= get_permalink($post_dt->ID);
				break;
			case "page":
				$post_dt= get_post($button_url[$ct]);
				$button_url[$ct]= get_permalink($post_dt->ID);
				break;
		}
		
		$patterns = array();
		$patterns[0] = '/{feature_class}/';
		$patterns[1] = '/{li_width}/';
		$patterns[2] = '/{currency}/';
		$patterns[3] = '/{price}/';
		$patterns[4] = '/{price_per}/';
		$patterns[5] = '/{title}/';
		$patterns[6] = '/{detail}/';
		$patterns[7] = '/{button_url}/';
		$patterns[8] = '/{button_text}/';
		$replacements = array();
		$replacements[0] = $feature_class;
		$replacements[1] = $li_width;
		$replacements[2] = $currency[$ct];
		$replacements[3] = $price[$ct];
		$replacements[4] = $price_per[$ct];
		$replacements[5] = $title[$ct];
		$replacements[6] = nl2br($detail[$ct]);
		$replacements[7] = $button_url[$ct];
		$replacements[8] = $button_text[$ct];
		$html= preg_replace($patterns, $replacements, $html);
		
		$feature_html= "";
		if( isset($feature_description[$feature_id]) ){
			foreach( $feature_description[$feature_id] as $item ){
				$patterns = array();
				$patterns[0] = '/{item}/';
				$replacements = array();
				$replacements[0] = $item;
				$feature_elem= $feature_tpl;
				
				$feature_elem= preg_replace($patterns, $replacements, $feature_elem);
				$feature_html.= $feature_elem;
			}			
		}
		$patterns = array();
		$patterns[0] = '#{loop}<li>.*</li>{/loop}#';
		$replacements = array();
		$replacements[0] = $feature_html;
		$html= preg_replace($patterns, $replacements, $html);
		echo $html;
		?>
<?php
	}
?>	
	</ul>
<?php
	}
}
wp_reset_postdata();
?>