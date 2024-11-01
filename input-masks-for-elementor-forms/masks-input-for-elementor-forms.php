<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('YEEADDONS_IP_MASKS_PLUGIN_PATH')) {
    define( 'YEEADDONS_IP_MASKS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    define( 'YEEADDONS_IP_MASKS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    class Yeeaddons_IP_Masks_Elementor_Init {
        function __construct(){
            add_action( 'elementor_pro/forms/fields/register', array($this,"load") );
        }
        function load($form_fields_registrar){
            include YEEADDONS_IP_MASKS_PLUGIN_PATH . "backend/field.php";
            $form_fields_registrar->register(new \Yeeaddons_IP_Masks_Elementor_Field_Masks());
        }
    }
    new Yeeaddons_IP_Masks_Elementor_Init;
}
