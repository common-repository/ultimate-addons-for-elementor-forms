<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('SUPERADDONS_ELEMENTOR_SIGNATURE_PLUGIN_PATH')) {
    define( 'SUPERADDONS_ELEMENTOR_SIGNATURE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'SUPERADDONS_ELEMENTOR_SIGNATURE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    //var_dump(SUPERADDONS_ELEMENTOR_SIGNATURE_PLUGIN_PATH);
    add_action( 'elementor_pro/forms/fields/register', 'superaddons_elementor_add_new_signature_field' );
    function superaddons_elementor_add_new_signature_field($form_fields_registrar){
        require_once( SUPERADDONS_ELEMENTOR_SIGNATURE_PLUGIN_PATH."fields/signature.php" );
        $form_fields_registrar->register( new \Superaddons_Elementor_Signature_Field() );
    }
}
