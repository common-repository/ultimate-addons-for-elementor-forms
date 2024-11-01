<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('SUPERADDONS_ELEMENTOR_RESTRICT_DATE_PLUGIN_PATH')) {
    define('SUPERADDONS_ELEMENTOR_RESTRICT_DATE_PLUGIN_PATH', plugin_dir_path(__FILE__));
    define('SUPERADDONS_ELEMENTOR_RESTRICT_DATE_PLUGIN_URL', plugin_dir_url(__FILE__));
    add_action('elementor_pro/forms/fields/register', 'superaddons_add_new_restrict_date_field');
    function superaddons_add_new_restrict_date_field($form_fields_registrar){
        include SUPERADDONS_ELEMENTOR_RESTRICT_DATE_PLUGIN_PATH . "fields/restrict_date.php";
        $form_fields_registrar->register(new \Superaddons_Restrict_Date_Field());
    }
}