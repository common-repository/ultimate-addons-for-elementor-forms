<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('ELEMENTOR_REPEATER_PLUGIN_PATH')) {
    define( 'ELEMENTOR_REPEATER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'ELEMENTOR_REPEATER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    add_action( 'elementor_pro/forms/fields/register', 'rednumber_add_new_repeater_field' );
    function rednumber_add_new_repeater_field($form_fields_registrar){
        require_once( ELEMENTOR_REPEATER_PLUGIN_PATH."fields/repeater_start.php" );
        require_once( ELEMENTOR_REPEATER_PLUGIN_PATH."fields/repeater_end.php" );
        require_once( ELEMENTOR_REPEATER_PLUGIN_PATH."fields/repeater_end.php" );
        $form_fields_registrar->register( new \Repeater_Start_Field() );
        $form_fields_registrar->register( new \Repeater_Field() );
    }
    class Rednumber_Repeater_Custom_Validation{
        function __construct(){
            add_action("elementor_pro/forms/validation/time",array($this,"custom_time_field"),9,3);
            add_action("elementor_pro/forms/validation/tel",array($this,"custom_tel_field"),9,3);
            add_action("elementor_pro/forms/validation/number",array($this,"custom_number_field"),9,3);
            if(isset($_GET["page"]) && $_GET["page"] == "e-form-submissions" ){
                add_action( 'admin_enqueue_scripts', array($this,"add_admin_js"));
            }
            add_action("elementor_pro/forms/validation/number",array($this,"custom_number_field"),9,3);
        }
        function add_admin_js($hook){
            wp_enqueue_script( 'elementor_repeater_admin', ELEMENTOR_REPEATER_PLUGIN_URL . 'libs/admin.js', array("jquery"),time() );
        }
        function custom_time_field($field, $record, $ajax_handler){
            $forms_module = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' );
            remove_action( 'elementor_pro/forms/validation/time', array( $forms_module->fields_registrar->get('time'), 'validation' ) );
            if ( empty( $field['value'] ) ) {
                return;
            }
            $values = explode(",", $field['value']);
            foreach( $values as $value ){
                $value = trim($value);
                if ( empty( $value ) ) {
                    return;
                }
                if ( preg_match( '/^(([0-1][0-9])|(2[0-3])):[0-5][0-9]$/', $value ) !== 1 ) {
                    $ajax_handler->add_error( $field['id'], esc_html__( 'Invalid Time, Time should be in HH:MM format!', 'elementor-pro' ) );
                }
            }  
        }
        function custom_tel_field($field, $record, $ajax_handler){
            $forms_module = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' );
            remove_action( 'elementor_pro/forms/validation/tel', array( $forms_module->fields_registrar->get('tel'), 'validation' ) );
            if ( empty( $field['value'] ) ) {
                return;
            }
            $values = explode(",", $field['value']);
            foreach( $values as $value ){
                $value = trim($value);
                if ( empty( $value ) ) {
                    return;
                }
                if ( preg_match( '/^[0-9()#&+*-=.]+$/', $value ) !== 1 ) {
                    $ajax_handler->add_error( $field['id'], esc_html__( 'Only numbers and phone characters (#, -, *, etc) are accepted.', 'elementor-pro' ) );
                }
            }  
        }
        function custom_number_field($field, $record, $ajax_handler){
            $forms_module = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' );
            remove_action( 'elementor_pro/forms/validation/number', array( $forms_module->fields_registrar->get('number'), 'validation' ) );
            if ( empty( $field['value'] ) ) {
                return;
            }
            $values = explode(",", $field['value']);
            foreach( $values as $value ){
                $value = trim($value);
                if ( empty( $value ) ) {
                    return;
                }
                if ( ! empty( $field['field_max'] ) && $field['field_max'] < (int) $value ) {
                    $ajax_handler->add_error( $field['id'], sprintf( esc_html__( 'The value must be less than or equal to %s', 'elementor-pro' ), $field['field_max'] ) );
                }
                if ( ! empty( $field['field_min'] ) && $field['field_min'] > (int) $value) {
                    $ajax_handler->add_error( $field['id'], sprintf( esc_html__( 'The value must be greater than or equal %s', 'elementor-pro' ), $field['field_min'] ) );
                }
            }  
        }
    }
    new Rednumber_Repeater_Custom_Validation;
}