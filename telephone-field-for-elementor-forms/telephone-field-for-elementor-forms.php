<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('ELEMENTOR_TELEPHONE_PLUGIN_PATH')) {
    define( 'ELEMENTOR_TELEPHONE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'ELEMENTOR_TELEPHONE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    add_action( 'elementor_pro/forms/fields/register', 'rednumber_add_new_telephone_field' );
    function rednumber_add_new_telephone_field($form_fields_registrar){
        require_once( ELEMENTOR_TELEPHONE_PLUGIN_PATH."fields/telephone.php" );
        $form_fields_registrar->register( new \Superaddons_Telephone_Field() );
    }
}