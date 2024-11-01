<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!defined('ELEMENTOR_COST_CALCULATOR_PLUGIN_PATH')) {
    define( 'ELEMENTOR_COST_CALCULATOR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    define( 'ELEMENTOR_COST_CALCULATOR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    class Eelementor_Cost_Calculator_Init {
        function __construct(){
            add_action("elementor/frontend/after_register_scripts",array($this,"add_lib"));
            add_action("elementor/editor/before_enqueue_scripts",array($this,"add_lib_backend"));
            add_action( 'elementor/widgets/register', array($this,'register_calculator_widget') );
            add_action( 'elementor_pro/init', array($this,'add_form_pro') );
        }
        function register_calculator_widget($widgets_manager){
            include ELEMENTOR_COST_CALCULATOR_PLUGIN_PATH."free/number.php";
            include ELEMENTOR_COST_CALCULATOR_PLUGIN_PATH."free/total.php";
            $widgets_manager->register( new \Number_Format_Cost_Calculator_Widget() );
            $widgets_manager->register( new \Total_Format_Cost_Calculator_Widget() );
        }
        function add_form_pro(){
            include ELEMENTOR_COST_CALCULATOR_PLUGIN_PATH."fields/number_formats.php";
            include ELEMENTOR_COST_CALCULATOR_PLUGIN_PATH."fields/total.php";
        }
        function add_lib_backend(){
            wp_enqueue_style(
                    'tribute',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/tribute/tribute.css'
                );
            wp_enqueue_script(
                    'tribute',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/tribute/tribute.js',
                );
                wp_enqueue_script(
                    'elementor-calculator',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/calculator_editor.js',
                    array("jquery","tribute"),
                    '1.0',
                    true
                );
            $check = get_option( '_redmuber_item_1529');
            $datas = array();
            $datas_done = array();
            $text_pro = "";
            $disable_pro = "";
            if($check != "ok"){
                $text_pro = "-Pro version";
                $disable_pro = " disabled";
            }
            $datas[] = array("key"=>"if( condition, true, false)", "value"=>"if( condition, true, false)");
            $datas[] = array("key"=>"if( condition, true, if(condition, true, false))", "value"=>"if( condition, true, if( condition, true, false))");
            $datas[] = array("key"=>"days( date_end, date_start)", "value"=>"days( end, start)");
            $datas[] = array("key"=>"months( date_end, date_start)", "value"=>"months( end, start)");
            $datas[] = array("key"=>"years( date_end, date_start)", "value"=>"years( end, start)");
            $datas[] = array("key"=>"round( number )", "value"=>"round( number )");
            $datas[] = array("key"=>"round2( number, decimal)", "value"=>"round2( number, 2)");
            $datas[] = array("key"=>"floor( number )", "value"=>"floor( number )");
            $datas[] = array("key"=>"floor2( number, decimal)", "value"=>"floor2( number, 2)");
            $datas[] = array("key"=>"ceil( number )", "value"=>"ceil( number )");
            $datas[] = array("key"=>"mod( number % number)", "value"=>"mod( number, number)");
            $datas[] = array("key"=>"age( Birth date )", "value"=>"age()");
            $datas[] = array("key"=>"age2( Birth date, Age at the Date of)", "value"=>"age2( birth_date, date)");
            $datas[] = array("key"=>"now (Current date)", "value"=>"now");
            $datas[] = array("key"=>"==", "value"=>"==");
            $datas[] = array("key"=>"pi = 3.14", "value"=>"pi");
            $datas[] = array("key"=>"e = 2.71", "value"=>"e");
            $datas[] = array("key"=>"abs( -3 ) = 3", "value"=>"abs( number )");
            $datas[] = array("key"=>"sqrt( 16 ) = 4", "value"=>"sqrt( number )");
            $datas[] = array("key"=>"sin( 0 ) = 0", "value"=>"sin( number )");
            $datas[] = array("key"=>"cos( 0 ) = 1", "value"=>"cos( number )");
            $datas[] = array("key"=>"pow( 2,3 ) = 8", "value"=>"pow( number , number )");
            $datas[] = array("key"=>"random( number start , number end ) ", "value"=>"random( number, number )");
            $datas[] = array("key"=>"mod( 2,3) = 1", "value"=>"mod( number, number )");
            $datas[] = array("key"=>"avg( 10,20,60,...) = 30", "value"=>"avg( number, number )");
            $datas[] = array("key"=>"min( number 1, number 2, ...)", "value"=>"min( number1, number2)");
            $datas[] = array("key"=>"max( number 1, number 2, ...)", "value"=>"max( number1, number2)");
            $datas[] = array("key"=>"sum( number 1, number 2, ...)", "value"=>"sum( number1, number2)");
            $datas[] = array("key"=>"rounded_multiple( number 1, number 2)", "value"=>"rounded_multiple( 7, 5)");
            foreach( $datas as $data ){
                $datas_done[] = array("key"=>$data["key"].$text_pro,"value"=>$data["value"]);
            }
            $datas_done[] = array("key"=>"a + b", "value"=>"+");
            $datas_done[] = array("key"=>"a - b", "value"=>"-");
            $datas_done[] = array("key"=>"a / b", "value"=>"/");
            $datas_done[] = array("key"=>"a * b", "value"=>"*");
            wp_localize_script( "elementor-calculator", "elementor_calculator", array("data"=>$datas_done) );
        }
        function add_lib(){
            wp_enqueue_script(
                    'evaluator',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/formula_evaluator-min.js',
                    array("jquery"),
                    '1.3.8',
                    true
                );
                wp_enqueue_script(
                    'autoNumeric',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/autoNumeric-1.9.45.js',
                    array("jquery"),
                    '1.9.45',
                    true
                );
                wp_enqueue_script(
                    'tribute',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/tribute/tribute.js',
                );
                wp_enqueue_script(
                    'elementor-calculator',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/calculator.js',
                    array("jquery","evaluator","autoNumeric","tribute"),
                    '1.1',
                    true
                );
                wp_enqueue_style(
                    'elementor-calculator',
                    ELEMENTOR_COST_CALCULATOR_PLUGIN_URL . 'libs/calculator.css'
                );
                
        }
    }
    new Eelementor_Cost_Calculator_Init;
}