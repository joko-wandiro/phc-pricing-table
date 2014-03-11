<?php
/*
Plugin Name: Pricing Table Extended
Plugin URI: http://wordpress.org/plugins/pricing-table-extended/
Description: Create Pricing Table easily with many theme available for you.
Version: 1.0.0
Author: Joko Wandiro
Author URI: http://www.phantasmacode.com
*/
define("PHC_PRICING_TABLE_VERSION", "1.0");
define('PHC_PRICING_TABLE_NAME', "Pricing Table Extended");
define('PHC_PRICING_TABLE_IDENTIFIER', "phc-pricing-table");
define('PHC_PRICING_TABLE_ID_SCRIPT', "phc_pricing_table");

load_plugin_textdomain(PHC_PRICING_TABLE_IDENTIFIER, FALSE, PHC_PRICING_TABLE_IDENTIFIER . "/languages");

define('PHC_PRICING_TABLE_PATH', plugin_dir_path(__FILE__));
define('PHC_PRICING_TABLE_INCLUDE_PATH', PHC_PRICING_TABLE_PATH . "inc/");
define('PHC_PRICING_TABLE_THEME_PATH', PHC_PRICING_TABLE_PATH . "theme/");
define('PHC_PRICING_TABLE_PATH_URL', plugin_dir_url(__FILE__));
define('PHC_PRICING_TABLE_THEME_URL', PHC_PRICING_TABLE_PATH_URL . "theme/");
define('PHC_PRICING_TABLE_PATH_URL_CSS', PHC_PRICING_TABLE_PATH_URL . "css/");
define('PHC_PRICING_TABLE_IMG_URL', PHC_PRICING_TABLE_PATH_URL . "img/");
define('PHC_PRICING_TABLE_IMAGES_BANNER', PHC_PRICING_TABLE_IMG_URL . "banner/");
define('PHC_PRICING_TABLE_IMG_DOCUMENTATION_BOW_TO_USE_URL', PHC_PRICING_TABLE_PATH_URL . 
"img/documentation/how-to-use/");
define('PHC_PRICING_TABLE_IMG_DOCUMENTATION_THEMES_URL', PHC_PRICING_TABLE_PATH_URL . 
"img/documentation/themes/");
define('PHC_PRICING_TABLE_IMG_DOCUMENTATION_NEW_THEMES_URL', PHC_PRICING_TABLE_PATH_URL . 
"img/documentation/new-themes/");
define("PHC_PRICING_TABLE_POST_TYPE", "pricing-tables");
define("PHC_PRICING_TABLE_SUBMENU_CAPABILITY", "manage_options");
define("PHC_PRICING_TABLE_MENU_SLUG_DOCUMENTATION", "pricing_tables_documentation");
define("PHC_PRICING_TABLE_PAGE_TITLE_DOCUMENTATION", __("Documentation", PHC_PRICING_TABLE_IDENTIFIER));
define("PHC_PRICING_TABLE_MENU_TITLE_DOCUMENTATION", PHC_PRICING_TABLE_PAGE_TITLE_DOCUMENTATION);

require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "backend_ajax.php");
require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "post_type.php");
require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "meta_boxes.php");
require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "manage_columns.php");
require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "shortcode.php");
require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "admin_scripts.php");
require_once(PHC_PRICING_TABLE_INCLUDE_PATH . "pages/documentation.php");
?>