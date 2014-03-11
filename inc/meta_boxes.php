<?php
// Start Add Meta Box
add_action("do_meta_boxes", "phc_pricing_table_add_meta");
function phc_pricing_table_add_meta(){
	global $wp_meta_boxes;
	if( isset($wp_meta_boxes[PHC_PRICING_TABLE_POST_TYPE]['side']) ){
		$side_meta_boxes= $wp_meta_boxes[PHC_PRICING_TABLE_POST_TYPE]['side'];
		foreach( $side_meta_boxes as $key=>$meta_box ){
			if( $key != "core" ){
				foreach( $meta_box as $subkey=>$item ){
					remove_meta_box($subkey, PHC_PRICING_TABLE_POST_TYPE, 'side');
				}
			}
		}
	}
	add_meta_box("pricing-table-meta", "Pricing Table Settings", "phc_pricing_table_meta_options", 
	PHC_PRICING_TABLE_POST_TYPE, "normal", "high");
}

function phc_pricing_table_meta_options($post, $metabox){
	global $post, $wp_scripts, $wp_meta_boxes, $hook_suffix;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	
	$custom= get_post_custom($post->ID);
	$meta_fields= array("plan_id", "title", "detail", "currency", "price", "price_per", "button_url_type", 
	"button_url", "button_text", "feature_description", "set_feature", "theme");	
	$datas= array();
	foreach( $meta_fields as $field ){
		if( isset($custom[$field][0]) ){
		$$field= json_decode($custom[$field][0], TRUE);
		$datas[$field]= json_decode($custom[$field][0], TRUE);
		}
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
		
	$num_section= isset($title) ? count($title) : "";

	wp_enqueue_style(PHC_PRICING_TABLE_ID_SCRIPT . '_post_css', PHC_PRICING_TABLE_PATH_URL_CSS . "post.css");
?>
<div id="pricing-table-extras" class="meta-box-wrapper" data-post-id="<?php echo $post->ID; ?>">
	<div>
	<button type="button" id="btn-new-plan" class="button-primary">
	<?php _e("New Plan", PHC_PRICING_TABLE_IDENTIFIER); ?></button>
	</div>
	<!-- Start Pricing Table Element -->
	<div class="group widget template-pricing-table-form">
	<div class="btn-icon-header phc-icon-delete" 
	title="<?php _e("Delete", PHC_PRICING_TABLE_IDENTIFIER); ?>">
	<button class="button-secondary btn-remove-plan" type="button">
	<?php _e("Remove", PHC_PRICING_TABLE_IDENTIFIER); ?></button>
	</div>
	<div class="btn-icon-header" title="<?php _e("Delete", PHC_PRICING_TABLE_IDENTIFIER); ?>">
	<input type="radio" id="feature-plan-{plan_number_title}" name="set_feature" value="{plan_number_title}" 
	disabled="" />
	<label for="feature-plan-{plan_number_title}" class="no-float">
	<?php _e("Set Recommended / Popular", PHC_PRICING_TABLE_IDENTIFIER); ?></label>
	</div>
	<h3 class="hndle">
	<span><?php _e("Plan", PHC_PRICING_TABLE_IDENTIFIER); ?> {plan_number_title}</span>
	</h3>
	<div class="pricing-table-section">
		<input type="hidden" name="plan_id[]" value="{plan_number_title}" disabled="" />
		<div>
		<label for="title[]"><?php _e("Title", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
		<input type="text" name="title[]" id="title[]" value="Plan {plan_number_title}" disabled="" />
		</div>
		<div>
		<label for="detail[]"><?php _e("Detail", PHC_PRICING_TABLE_IDENTIFIER); ?>: </label>
		<textarea id="detail[]" name="detail[]" cols="10" 
		rows="10" disabled=""></textarea>
		</div>
		<div>
		<label for="price[]"><?php _e("Price", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
		<input type="text" name="currency[]" class="currency-input" value="" disabled="" />
		<input type="text" name="price[]" class="price-input"  value="" disabled="" />
		<span>/</span>
		<input type="text" name="price_per[]" class="price_per-input" value="" disabled="" />
		</div>
		<div>
		<label><?php _e("Button Url", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
		<div class="controls-input">
		<input type="radio" name="button_url_type[{plan_number}]" id="button_url_type[{plan_number}_custom_url]" 
		value="custom_url" checked="" disabled="" />
		<label for="button_url_type[{plan_number}_custom_url]">Custom Url</label>
		<input type="radio" name="button_url_type[{plan_number}]" id="button_url_type[{plan_number}_post]" 
		value="post" disabled="" />
		<label for="button_url_type[{plan_number}_post]">Post</label>
		<input type="radio" name="button_url_type[{plan_number}]" id="button_url_type[{plan_number}_page]" 
		value="page" disabled="" />
		<label for="button_url_type[{plan_number}_page]">Page</label>
		</div>
		</div>
		<div>
		<label for="button_text[]"><?php _e("Button Text", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
		<input id="button_text[]" type="text" name="button_text[]" value="" disabled="" />
		</div>
		<div>
		<button class="button-secondary btn-add-feature-plan" type="button" 
		data-plan-id="feature_description[{plan_number_title}]">
		<?php _e("Add Feature", PHC_PRICING_TABLE_IDENTIFIER); ?></button>
		</div>
		
		<div class="pricing-table-features">
		</div>
	</div>
	</div>
	<!-- End Pricing Table Element -->
	
	<!-- Start Pricing Table Features Element -->
	<div class="template-pricing-table-features-element">
	<input type="text" id="{id_plan_features}[]" name="{id_plan_features}[]" value="" disabled="" />
	<button class="button-secondary btn-remove-feature-plan" type="button">
	<?php _e("Remove", PHC_PRICING_TABLE_IDENTIFIER); ?></button>
	</div>
	<!-- End Pricing Table Features Element -->
	
	<div id="pricing-table-accordion">
	<?php
	if( !empty($num_section) ){
	for( $ct=0; $ct<$num_section; $ct++ ){
		$feature_stat= "";
		if( $plan_id[$ct] == $set_feature ){
			$feature_stat= " checked=\"checked\"";
		}
		$plan_number= $ct+1;
		$feature_id= $plan_id[$ct];
	?>
		<div class="group widget" data-plan-number="<?php echo $plan_number; ?>">
		<div class="btn-icon-header phc-icon-delete" 
		title="<?php _e("Delete", PHC_PRICING_TABLE_IDENTIFIER); ?>">
		<button class="button-secondary btn-remove-plan" type="button">
		<?php _e("Remove", PHC_PRICING_TABLE_IDENTIFIER); ?></button>
		</div>
		<div class="btn-icon-header" title="<?php _e("Delete", PHC_PRICING_TABLE_IDENTIFIER); ?>">
		<input type="radio" id="feature-plan-<?php echo $plan_number; ?>" name="set_feature" 
		value="<?php echo $plan_number; ?>"<?php echo $feature_stat; ?> />
		<label for="feature-plan-<?php echo $plan_number; ?>" class="no-float">
		<?php _e("Set Recommended / Popular", PHC_PRICING_TABLE_IDENTIFIER); ?></label>
		</div>
		<h3 class="hndle"><span><?php echo $title[$ct]; ?></span></h3>
		<div class="pricing-table-section">
			<input type="hidden" name="plan_id[]" value="<?php echo $plan_number; ?>" />
			<div>
			<label for="title[]"><?php _e("Title", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
			<input type="text" name="title[]" id="title[]" 
			value="<?php echo esc_attr($title[$ct]); ?>" />
			</div>
			<div>
			<label for="detail[]"><?php _e("Detail", "phc_branches_post_type"); ?>: </label>
			<textarea id="detail[]" name="detail[]" cols="10" 
			rows="10"><?php echo esc_attr($detail[$ct]); ?></textarea>
			</div>
			<div>
			<label for="price[]"><?php _e("Price", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
			<input type="text" name="currency[]" class="currency-input" 
			value="<?php echo esc_attr($currency[$ct]); ?>" />
			<input id="price[]" type="text" name="price[]" class="price-input" 
			value="<?php echo esc_attr($price[$ct]); ?>" />
			<span>/</span>
			<input type="text" name="price_per[]" class="price_per-input" 
			value="<?php echo esc_attr($price_per[$ct]); ?>" />
			</div>
			<div>
			<label><?php _e("Button Url", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
			<div class="controls-input">
			<input type="radio" name="button_url_type[<?php echo $ct; ?>]" 
			id="button_url_type[<?php echo $ct; ?>_custom_url]" value="custom_url" 
			<?php echo ( $button_url_type[$ct] == "custom_url" ) ? "checked=\"\"" : ""; ?> />
			<label for="button_url_type[<?php echo $ct; ?>_custom_url]">Custom Url</label>
			<input type="radio" name="button_url_type[<?php echo $ct; ?>]" 
			id="button_url_type[<?php echo $ct; ?>_post]" value="post" 
			<?php echo ( $button_url_type[$ct] == "post" ) ? "checked=\"\"" : ""; ?> />
			<label for="button_url_type[<?php echo $ct; ?>_post]">Post</label>
			<input type="radio" name="button_url_type[<?php echo $ct; ?>]" 
			id="button_url_type[<?php echo $ct; ?>_page]" value="page" 
			<?php echo ( $button_url_type[$ct] == "page" ) ? "checked=\"\"" : ""; ?> />
			<label for="button_url_type[<?php echo $ct; ?>_page]">Page</label>
			</div>
			</div>
			<div class="button_url">
			<label>&nbsp;</label>
			<?php
			switch ($button_url_type[$ct]){
				case "custom_url":
			?>
			<input id="button_url[]" type="text" name="button_url[]" 
			value="<?php echo esc_attr($button_url[$ct]); ?>" data-type="custom_url" />
			<?php
					break;
				case "post":
			?>
			<select name="button_url[]" data-type="post">
			<?php
			foreach( $posts as $item ){
				$selected= "";
				if( $item->ID == $button_url[$ct] ){
					$selected= " selected=\"selected\"";
				}
			?>
			<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
			<?php echo $item->post_title; ?></option>
			<?php
			}
			?>
			</select>			
			<?php
					break;
				case "page":
			?>			
			<select name="button_url[]" data-type="page">
			<?php
			foreach( $pages as $item ){
				$selected= "";
				if( $item->ID == $button_url[$ct] ){
					$selected= " selected=\"selected\"";
				}
			?>
			<option value="<?php echo $item->ID; ?>"<?php echo $selected; ?>>
			<?php echo $item->post_title; ?></option>
			<?php
			}
			?>
			</select>
			<?php
					break;
			}
			?>
			</div>
			<div>
			<label for="button_text[]"><?php _e("Button Text", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
			<input id="button_text[]" type="text" name="button_text[]" 
			value="<?php echo esc_attr($button_text[$ct]); ?>" />
			</div>
			<div>
			<button class="button-secondary btn-add-feature-plan" type="button" 
			data-plan-id="feature_description[<?php echo $plan_number; ?>]">
			<?php _e("Add Feature", PHC_PRICING_TABLE_IDENTIFIER); ?>
			</button>
			</div>
			<div class="pricing-table-features">
			<?php
			if( isset($feature_description[$feature_id]) ){
				foreach( $feature_description[$feature_id] as $item ){
			?>
			<div class="">
			<input type="text" name="feature_description[<?php echo $plan_number; ?>][]" 
			value="<?php echo esc_attr($item); ?>" />
			<button class="button-secondary btn-remove-feature-plan" type="button">
			<?php _e("Remove", PHC_PRICING_TABLE_IDENTIFIER); ?></button>
			</div>
			<?php
				}
			}
			?>
			</div>
		</div>
		</div>
	<?php
	}
	}
	?>
	</div>

	<div id="theme-section">
	<?php
	$all_themes= glob(PHC_PRICING_TABLE_THEME_PATH . '*', GLOB_ONLYDIR);
	?>
	<div>
	<label for="theme"><?php _e("Theme", PHC_PRICING_TABLE_IDENTIFIER); ?>:</label>
	<select name="theme" id="theme">
	<?php
	$theme_curr= basename($all_themes[0]);
	foreach( $all_themes as $item ){
		$theme_name= basename($item);
		$selected= "";
		if( $theme_name == $theme ){
			$selected= " selected=\"selected\"";
			$theme_curr= $theme;
		}
	?>
	<option value="<?php echo $theme_name; ?>"<?php echo $selected; ?>>
	<?php echo ucfirst(basename($theme_name)); ?></option>
	<?php
	}
	?>
	</select>
	</div>
	<div id="theme-preview">
	<img src="<?php echo PHC_PRICING_TABLE_THEME_URL . $theme_curr; ?>/preview.png" />
	</div>
	</div>
</div>
<?php
}
// End Add Meta Box

// Start Save Post
add_action('save_post', 'phc_pricing_table_save_extras');
function phc_pricing_table_save_extras(){
	global $post;
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}
	else{
		$meta_fields= array("plan_id", "title", "detail", "currency", "price", "price_per", 
		"button_url_type", "button_url", "button_text", "feature_description", "set_feature", "theme");
		// Validate Data
		
		// Save Data
		foreach( $meta_fields as $field ){
			if( isset($_POST[$field]) ){
				if( $field != "feature_description" ){
					if( ! is_array($_POST[$field]) ){
						$_POST[$field]= sanitize_text_field($_POST[$field]);
					}else{
						foreach( $_POST[$field] as $key=>$item ){
							$_POST[$field][$key]= sanitize_text_field($item);
						}
					}
				}else{
					for( $ct=1; $ct<=count($_POST[$field]); $ct++ ){
						foreach( $_POST[$field][$ct] as $subkey=>$subitem ){
							$_POST[$field][$ct][$subkey]= sanitize_text_field($subitem);
						}
					}
				}
								
				if( $field == "button_url_type" ){
					$button_url_type_arr= array();
					foreach( $_POST[$field] as $key=>$item ){
						$button_url_type_arr[]= sanitize_text_field($item);
					}
					$_POST[$field]= $button_url_type_arr;
				}
				update_post_meta($post->ID, $field, json_encode($_POST[$field]));
			}
		}
	}
}
// End Save Post
?>