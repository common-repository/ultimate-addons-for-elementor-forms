<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action( "yeeaddons_check_purchase_ok", "yeeaddons_ultimate_elementor_update",10,2 );
add_action( "yeeaddons_check_purchase_remove", "yeeaddons_ultimate_elementor_remove",10 );
function yeeaddons_ultimate_elementor_update($id_product,$code){
    if($id_product == 4433){
        $lists = array(3353,1538,1529,1527,1524,1523,1509,1507,1473);
        foreach($lists as $id){
            update_option( '_redmuber_item_'.$id, "ok" );
            update_option( '_redmuber_item_'.$id."_code", $code );
        }
    }
}
function yeeaddons_ultimate_elementor_remove($id_product,$code){
    if($id_product == 4433){
        $lists = array(3353,1538,1529,1527,1524,1523,1509,1507,1473);
        foreach($lists as $id){
            delete_option('_redmuber_item_'.$id);
			delete_option('_redmuber_item_'.$id."_code");
        }
    }
}