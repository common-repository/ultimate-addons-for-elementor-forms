<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Yeeaddons_IP_Masks_Elementor_Field_Masks extends \ElementorPro\Modules\Forms\Fields\Field_Base{
    public function get_type(){
        return 'yee_input_masks';
    }
    public function get_name(){
        return esc_html__('Input Masks', 'input-masks-for-elementor-forms');
    }
    public function editor_preview_footer() {
		add_action( 'wp_footer', array($this,"signature_content_template_script"));
	}
    function signature_content_template_script(){
        ?>
        <script>
        jQuery( document ).ready( () => {
            elementor.hooks.addFilter(
                'elementor_pro/forms/content_template/field/yee_input_masks',
                function ( inputField, item, i ) {
                    return `<input type="text />"`;
                }, 10, 3
            );
        });
        </script>
        <?php
    }
    public function update_controls($widget){
        $elementor = \ElementorPro\Plugin::elementor();
        $control_data = $elementor->controls_manager->get_control_from_stack($widget->get_unique_name(), 'form_fields');
        if (is_wp_error($control_data)) {
            return;
        }
        $field_controls = [
            'yee_input_masks_type' => [
                'name' => 'yee_input_masks_type',
                'label' => esc_html__('Type', 'input-masks-for-elementor-forms'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => "standard",
                'condition' => [
                    'field_type' => $this->get_type(),
                ],
                'options'=>array("standard"=>"Standard","custom"=>"Custom"),
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
            'yee_input_masks_type_standard' => [
                'name' => 'yee_input_masks_type_standard',
                'label' => esc_html__('Standard', 'input-masks-for-elementor-forms'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => '(999) 999-9999',
                'options'=>array(
                    "(999) 999-9999"=>"US Phone",
                    "(999) 999-9999? x99999"=>"US Phone + EXT",
                    "99-9999999"=>"Tax ID",
                    "999-99-9999"=>"SSN",
                    "99999"=>"Zipcode",
                    "99999?-9999"=>"Full Zipcode",
                ),
                'condition' => [
                    'field_type' => $this->get_type(),
                    'yee_input_masks_type'=>'standard'
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
            'yee_input_masks_type_custom' => [
                'name' => 'yee_input_masks_type_custom',
                'label' => esc_html__('Custom', 'input-masks-for-elementor-forms'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'description'=>'See <a href="https://add-ons.org/document-input-masks-for-elementor-forms/" target="blank">Examples & Docs</a>',
                'condition' => [
                    'field_type' => $this->get_type(),
                    'yee_input_masks_type'=>'custom'
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
        ];
        $control_data['fields'] = $this->inject_field_controls($control_data['fields'], $field_controls);
        $widget->update_control('form_fields', $control_data);
    }
    public function render($item, $item_index, $form){
        $form->add_render_attribute('input' . $item_index, 'class', 'elementor-field-input-maks elementor-field-textual');
        $form->add_render_attribute('input' . $item_index, 'type', 'text', true);
        $type = ! empty($item['yee_input_masks_type']) ? $item['yee_input_masks_type'] : 'standard';
        if($type == "standard"){
            $mask = ! empty($item['yee_input_masks_type_standard']) ? $item['yee_input_masks_type_standard'] : '(999) 999-9999';
        }else{
            $mask = ! empty($item['yee_input_masks_type_custom']) ? $item['yee_input_masks_type_custom'] : '';
        }
        $mask = str_replace("!9","\\\9",$mask);
        $form->add_render_attribute('input' . $item_index, 'data-inputmask', "'mask': '".$mask."'", true);
        $input = sprintf(
            '<input type="text" %s>',
            $form->get_render_attribute_string('input' . $item_index),
        );
        echo $input; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
        <input type="hidden" name="form_fields[<?php echo esc_attr( $item['custom_id'] ) ?>_check]" class="yeeaddons_input_maks_check hidden">
        <?php
    }
    public function validation( $field, $record, $ajax_handler ) {
		if($field['value'] != "" ){
			$datas_submit = map_deep( $_POST['form_fields'], 'sanitize_text_field' );
			if( isset($datas_submit[$field["id"]."_check"])) {
				if($datas_submit[$field["id"]."_check"] == "no"){
					$ajax_handler->add_error( $field['id'], esc_html__( 'Please fill out the field in required format.', 'elementor-pro' ));
				}
			}
		}
	}
    public function __construct(){
        parent::__construct();
        add_action("wp_enqueue_scripts", array($this, "add_lib"), 1000);
        add_action( 'elementor/preview/init', array( $this, 'editor_preview_footer' ) );
    }
    function add_lib(){
        wp_enqueue_script("inputmask",YEEADDONS_IP_MASKS_PLUGIN_URL."libs/Inputmask/jquery.inputmask.min.js",array("jquery"));
        wp_enqueue_script("inputmask_elementor",YEEADDONS_IP_MASKS_PLUGIN_URL."libs/inputmask_elementor.js",array("jquery"));
    }
}