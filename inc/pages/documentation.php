<?php
add_action('admin_print_scripts', 'phc_pricing_table_admin_print_scripts_documentation');
function phc_pricing_table_admin_print_scripts_documentation(){
	wp_enqueue_style(PHC_PRICING_TABLE_ID_SCRIPT . '_admin_css', PHC_PRICING_TABLE_PATH_URL_CSS . "admin.css");
}

add_action('admin_menu', 'phc_branches_post_type_create_menu');
function phc_branches_post_type_create_menu(){
	global $wp_scripts;
	
	$function= "phc_pricing_table_documentation";
	add_submenu_page('edit.php?post_type=' . PHC_PRICING_TABLE_POST_TYPE, 
	PHC_PRICING_TABLE_PAGE_TITLE_DOCUMENTATION, PHC_PRICING_TABLE_MENU_TITLE_DOCUMENTATION, 
	PHC_PRICING_TABLE_SUBMENU_CAPABILITY, PHC_PRICING_TABLE_MENU_SLUG_DOCUMENTATION, $function);
}

function phc_pricing_table_documentation(){
	wp_enqueue_style(PHC_PRICING_TABLE_ID_SCRIPT . '_documentation_css', PHC_PRICING_TABLE_PATH_URL_CSS . 
	"documentation.css");
	wp_enqueue_script(PHC_PRICING_TABLE_ID_SCRIPT . '_documentation_js', PHC_PRICING_TABLE_PATH_URL . 
	"js/documentation/documentation.js", array("jquery-ui-tabs"));
?>
	<div class="wrap" id="<?php echo PHC_PRICING_TABLE_IDENTIFIER; ?>">
	<!-- Start Banner -->
	<ul id="banners">
	<li>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
	">
	<input type="image" src="<?php echo PHC_PRICING_TABLE_IMAGES_BANNER . "banner_donation.png"; ?>" border="0" name="submit" 
	alt="Help me with your Donation !">
	<img alt="" border="0" src="https://www.paypalobjects.com/id_ID/i/scr/pixel.gif" width="1" height="1">
	</form>
	</li>
	<li class="or"><img src="<?php echo PHC_CAMERA_IMAGES_BANNER . "banner_or.png"; ?>" /></li>
	<li><a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=phantasmacode"><img src="<?php echo PHC_PRICING_TABLE_IMAGES_BANNER . "banner_opencart.png"; ?>" /></a></li>
	</ul>
	<!-- End Banner -->
		
	<?php screen_icon('page'); ?>
	<h2><?php _e("Documentation", PHC_PRICING_TABLE_IDENTIFIER); ?></h2>
	
	<div id="tabs">
	<ul>
	<li><a href="#tabs-how-to-use"><?php _ex("How to Use", "documentation tab", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></a></li>
	<li><a href="#tabs-themes"><?php _ex("Customize Themes", "documentation tab", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></a></li>
	<li><a href="#tabs-new-themes"><?php _ex("Create New Theme", "documentation tab", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></a></li>
	<li><a href="#tabs-translation"><?php _ex("Translation", "documentation tab", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></a></li>
	</ul>
	<div id="tabs-how-to-use">
	<ul>
	<li>
	<p><?php _e("Goto Pricing Tables &gt; Add New Pricing Table.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("Enter Title. Ex: Pricing Table.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step1.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click New Plan to add each of your plan.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step2.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Fill fields of your plan like the following image.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step3.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Then add your next plan, assume like the following image.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step4.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click selectbox to select Theme for your pricing table.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step5.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Publish Button to save data.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img class="step6" src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . 
	"step6.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Goto Pricing Tables to view all of your pricing tables. You can add it into your post or page, just copy shortcode syntax on Shortcode column. Then you will get your pricing table on your post / page.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step7.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Goto Posts &gt; All Posts. Then click edit on specific post. You can create new post / page later, I use edit post just for example.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step8.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Add pricing table shortcode like the following image.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step9.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Click Update. Then click View Post button to check pricing table is shown on your post. You should see your post like the following image.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL . "step10.png"; ?>" />
	</p>
	</li>
	</ul>
	</div>
	<div id="tabs-themes">
	<ul>
	<li>
	<p><?php _e("Goto phc pricing table plugin directory ( wp-content/plugins/phc-pricing-table ). then select theme folder.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_THEMES_URL . "step1.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Theme pricing table have the following structure. For example I will use sort theme.", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_THEMES_URL . "step2.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("layout.tpl file contain html markup. Value which wrapped with curle bracket will be replaced with proper value using template parser.", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	</li>
	<li>
	<p><?php _e("theme.js contain javascript and theme.css contain stylesheet for your pricing table.", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	</li>
	</ul>
	</div>
	<div id="tabs-new-themes">
	<ul>
	<li>
	<p><?php _e("Copy – Paste folder sort and rename it to mine.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_NEW_THEMES_URL . "step1.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Goto Pricing Tables > Add New Pricing Table. Click selectbox theme and you can select your new theme.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p>
	<img src="<?php echo PHC_PRICING_TABLE_IMG_DOCUMENTATION_NEW_THEMES_URL . "step2.png"; ?>" />
	</p>
	</li>
	<li>
	<p><?php _e("Now you can create your own pricing table's theme and I will create extra page or something like that so you can share your theme to another user. Thanks everyone to use this plugin.", PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	</li>
	</ul>
	</div>
	<div id="tabs-translation">
	<ul>
	<li>
	<p><?php _e("Help me to Translate it. I provide POT file on languages folder. You can use translation application such as POEdit and translate it to your locale language and save it into PO file and MO file", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	<p><?php _e("You can contribute to make it bigger with your support guys !", 
	PHC_PRICING_TABLE_IDENTIFIER); ?></p>
	</li>
	</ul>
	</div>	
	</div>
	</div>
<?php
}
?>