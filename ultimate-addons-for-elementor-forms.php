<?php
/**
 * Plugin Name: Ultimate Addons for Elementor Forms
 * Requires Plugins: elementor
 * Description: Ultimate Addons for Elementor Forms is the must-have plugin to complement Elementor Forms
 * Version: 1.0.4
 * Author: add-ons.org
 * Elementor tested up to: 3.24
 * Elementor Pro tested up to: 3.24
 * Author URI: https://add-ons.org/
 * License: GPLv2 or later
 *License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'YEEADDONS_ELEMENTOR_ULTIMATE_PATH', plugin_dir_path( __FILE__ ) );
define( 'YEEADDONS_ELEMENTOR_ULTIMATE_URL', plugin_dir_url( __FILE__ ) );
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."conditional-logic-for-elementor-forms/conditional-logic-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."telephone-field-for-elementor-forms/telephone-field-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."signature-field-for-elementor-forms/signature-field-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."repeater-for-elementor/repeater-for-elementor.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."drag-and-drop-file-upload-for-elementor-forms/drag-and-drop-file-upload-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."range-slider-for-elementor-forms/range-slider-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."restrict-date-for-elementor-forms/restrict-date-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."cost-calculator-for-elementor/cost-calculator-for-elementor.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."pdf-for-elementor-forms/pdf-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."input-masks-for-elementor-forms/input-masks-for-elementor-forms.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."pro/index.php";
include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."superaddons/check_purchase_code.php";
new Superaddons_Check_Purchase_Code( 
    array(
        "plugin" => "ultimate-addons-for-elementor-forms/ultimate-addons-for-elementor-forms.php",
        "id"=>"4433",
        "pro"=>"https://add-ons.org/plugin/ultimate-addons-for-elementor-forms-pro/",
        "plugin_name"=> "Ultimate Addons for Elementor Forms",
        "document"=>"https://add-ons.org/add-ons/elementor-forms/"
    )
);
if(!class_exists('Superaddons_List_Addons')) {  
    include YEEADDONS_ELEMENTOR_ULTIMATE_PATH."add-ons.php"; 
}