<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('SUPERADDONS_FILE_UPLOAD_PLUGIN_PATH')) {
    define( 'SUPERADDONS_FILE_UPLOAD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'SUPERADDONS_FILE_UPLOAD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    add_action( 'elementor_pro/forms/fields/register', 'superaddons_elementor_pro_add_upload_field' );
    function superaddons_elementor_pro_add_upload_field($form_fields_registrar){
        require_once( SUPERADDONS_FILE_UPLOAD_PLUGIN_PATH."fields/file_upload.php" );
        $form_fields_registrar->register( new \Superaddons_EL_File_Uploads() );
    }
}