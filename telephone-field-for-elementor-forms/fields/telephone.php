<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Superaddons_Telephone_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {
	private $fixed_files_indices = false;
	public function get_type() {
		return 'telephone';
	}
	public function editor_preview_footer() {
		add_action( 'wp_footer', array($this,"telephone_content_template_script"));
	}
	function telephone_content_template_script(){
    ?>
    <script>
    jQuery( document ).ready( () => {
        elementor.hooks.addFilter(
            'elementor_pro/forms/content_template/field/telephone',
            function ( inputField, item, i ) {
                return `<input type="tel" readonly />`;
            }, 10, 3
        );
    });
    </script>
    <?php
}
	public function get_name() {
		return esc_html__( 'Telephone', 'elementor-telephone' );
	}
	/**
	 * @param Widget_Base $widget
	 */
	public function update_controls( $widget ) {
		$check_pro = get_option( '_redmuber_item_1524');
		$elementor = \ElementorPro\Plugin::elementor();
		$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );
		if ( is_wp_error( $control_data ) ) {
			return;
		}
		if($check_pro == "ok") {
			$field_controls = [
				'telephone_search' => [
					'name' => 'telephone_search',
					'label' => esc_html__( 'Country Search', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "yes",
					'description' => esc_html__( 'Add a search input to the top of the dropdown, so users can filter the displayed countries.', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_pre' => [
					'name' => 'telephone_pre',
					'label' => esc_html__( 'Preferred Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => 'us|gb',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Specify the countries to appear at the top of the list. Note that this option is not compatible with the countrySearch feature, and so that needs to be disabled for this to work.', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_onlyct' => [
					'name' => 'telephone_onlyct',
					'label' => esc_html__( 'Only Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'In the dropdown, display only the countries you specify - see example:us|gb|bg', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_excludeCountries' => [
					'name' => 'telephone_excludeCountries',
					'label' => esc_html__( 'Exclude Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'In the dropdown, display all countries except the ones you specify here. - see example.:us|gb|bg', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_defcountry' => [
					'name' => 'telephone_defcountry',
					'label' => esc_html__( 'Default Country', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'example: us --- default auto', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_auto' => [
					'name' => 'telephone_auto',
					'label' => esc_html__( 'Automatically select Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "yes",
					'description' => esc_html__( 'Automatically select the user current country using an IP', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_hide_flag' => [
					'name' => 'telephone_hide_flag',
					'label' => esc_html__( 'Hide Flag', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Show/hide Flag', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_hide_country_code' => [
					'name' => 'telephone_hide_country_code',
					'label' => esc_html__( 'Hide country code', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Show/hide country code', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_js' => [
					'name' => 'telephone_js',
					'label' => esc_html__( 'Javascript validation', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "yes",
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_usformat' => [
					'name' => 'telephone_usformat',
					'label' => esc_html__( 'Us Phone format', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "no",
					'description' => esc_html__( '(234) 111-2222', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
			];
		}else{
			$field_controls = [
				'telephone_search_pro' => [
					'name' => 'telephone_search_pro',
					'label' => esc_html__( 'Country Search', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'content_classes' => 'pro_disable elementor-panel-alert elementor-panel-alert-info',
					'raw' => esc_html__( 'Add a search input to the top of the dropdown, so users can filter the displayed countries ( Upgrade to pro to enable)', 'repeater-for-elementor' ),
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_pre' => [
					'name' => 'telephone_pre',
					'label' => esc_html__( 'Preferred Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => 'us|gb',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Specify the countries to appear at the top of the list. Note that this option is not compatible with the countrySearch feature, and so that needs to be disabled for this to work.', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_onlyct' => [
					'name' => 'telephone_onlyct',
					'label' => esc_html__( 'Only Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'In the dropdown, display only the countries you specify - see example:us|gb|bg', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_excludeCountries_pro' => [
					'name' => 'telephone_excludeCountries_pro',
					'label' => esc_html__( 'Exclude Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'content_classes' => 'pro_disable elementor-panel-alert elementor-panel-alert-info',
					'raw' => esc_html__( 'In the dropdown, display all countries except the ones you specify here. ( Upgrade to pro)', 'repeater-for-elementor' ),
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_defcountry' => [
					'name' => 'telephone_defcountry',
					'label' => esc_html__( 'Default Country', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => 'us',
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Example: us --- default us', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_auto_pro' => [
					'name' => 'telephone_auto_pro',
					'label' => esc_html__( 'Automatically select Countries', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'content_classes' => 'pro_disable elementor-panel-alert elementor-panel-alert-info',
					'raw' => esc_html__( 'Automatically select the user current country using an IP ( Upgrade to pro to enable)', 'repeater-for-elementor' ),
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "yes",
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_hide_flag' => [
					'name' => 'telephone_hide_flag',
					'label' => esc_html__( 'Hide Flag', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Show/hide Flag', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_hide_country_code' => [
					'name' => 'telephone_hide_country_code',
					'label' => esc_html__( 'Hide country code', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'description' => esc_html__( 'Show/hide country code', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_js' => [
					'name' => 'telephone_js',
					'label' => esc_html__( 'Javascript validation', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "yes",
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'telephone_usformat' => [
					'name' => 'telephone_usformat',
					'label' => esc_html__( 'Us Phone format', 'elementor-telephone' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'default' => "no",
					'description' => esc_html__( 'E.g: (234) 111-2222', 'elementor-telephone' ),
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
			];
		}
		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
		$widget->update_control( 'form_fields', $control_data );
	}
	public function validation( $field, $record, $ajax_handler ) {
		if ( ! empty( $field['required'] ) && $field['required'] == "yes") {
			if(  strlen($field['value'] ) < 7 || strlen($field['value'] ) > 16 ) {
				$ajax_handler->add_error( $field['id'], esc_html__( 'Invalid phone format', 'elementor-pro' ));
			}
		}
		if($field['value'] != "" ){
			$datas_submit = map_deep( $_POST['form_fields'], 'sanitize_text_field' );
			if( isset($datas_submit[$field["id"]."_check"])) {
				if($datas_submit[$field["id"]."_check"] == "no"){
					$ajax_handler->add_error( $field['id'], esc_html__( 'Invalid phone format', 'elementor-pro' ));
				}
			}
		}
	}
	/**
	 * @param      $item
	 * @param      $item_index
	 * @param Form $form
	 */
	public function render( $item, $item_index, $form ) {
		$us_format = (isset($item['telephone_usformat'])?$item['telephone_usformat']:"no");
		if($us_format == "yes"){
			$class ="elementor-field-telephone elementor-field-textual elementor-field-telephone-us";
		}else{
			$class ="elementor-field-telephone elementor-field-textual";
		}
		
		$form->add_render_attribute( 'input' . $item_index, 'class', $class);
		$form->add_render_attribute( 'input' . $item_index, 'type', 'text', true );		
		if ( isset( $item['telephone_auto'] ) ) {
			$form->add_render_attribute( 'input' . $item_index, 'data-auto', esc_attr( $item['telephone_auto'] ) );
		}
		$telephone_search = (isset($item['telephone_search'])?$item['telephone_search']:"");
		$telephone_defcountry = (isset($item['telephone_defcountry'])?$item['telephone_defcountry']:"");
		$telephone_excludeCountries = (isset($item['telephone_excludeCountries'])?$item['telephone_excludeCountries']:"");
		$form->add_render_attribute( 'input' . $item_index, 'data-pre', esc_attr( $item['telephone_pre'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-excludeCountries', esc_attr( $telephone_excludeCountries ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-onlyct', esc_attr( $item['telephone_onlyct'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-defcountry', esc_attr( $telephone_defcountry ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-hide_flag', esc_attr( $item['telephone_hide_flag'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-hide_code', esc_attr( $item['telephone_hide_country_code'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-validation', esc_attr( $item['telephone_js'] ) );	
		$form->add_render_attribute( 'input' . $item_index, 'data-name', $item["custom_id"] );
		$form->add_render_attribute( 'input' . $item_index, 'data-telephone_search', $telephone_search );
		$form->add_render_attribute( 'input' . $item_index, 'name', "change_name_".$item["custom_id"],true );
		?>
		<input <?php $form->print_render_attribute_string( 'input' . $item_index ); ?> >
		<input onkeydown="return /[0-9]|\(|\)|\+|-|BACKSPACE/i.test(event.key)" type="hidden" class="phone_check" name="form_fields[<?php echo esc_attr($item["custom_id"]) ?>_check]" value="" >
		<?php
	}
	public function __construct() {
		parent::__construct();
		add_action("wp_enqueue_scripts",array($this,"add_lib"),1000);
		add_action("wp_head",array($this,"wp_head"),1000);
		add_action( 'elementor/preview/init', array( $this, 'editor_preview_footer' ) );
	}
	function add_lib(){
		wp_enqueue_script("intlTelInput_elementor",ELEMENTOR_TELEPHONE_PLUGIN_URL."lib/js/intlTelInput-jquery.js",array("jquery"));
        wp_enqueue_script("elementor_tel",ELEMENTOR_TELEPHONE_PLUGIN_URL."lib/js/elementor_tel.js",array("jquery"));
        wp_localize_script( 'elementor_tel', 'elementor_tel',array("utilsScript"=>ELEMENTOR_TELEPHONE_PLUGIN_URL."lib/js/utils.js"),);
        wp_enqueue_style("intlTelInput",ELEMENTOR_TELEPHONE_PLUGIN_URL."lib/css/intlTelInput.min.css",array());
        wp_enqueue_style("elementor_tel",ELEMENTOR_TELEPHONE_PLUGIN_URL."lib/css/elementor-tel.css",array(),"10.4.7");
	}
	function wp_head(){
		if ( ! function_exists( 'is_plugin_active' ) ){
			include_once(ABSPATH.'wp-admin/includes/plugin.php');
		}
		if(is_plugin_active( 'litespeed-cache/litespeed-cache.php' ) || is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' )){
			?>
			<style type="text/css">
			.iti__flag {
				background-image: url(https://cdn.add-ons.org/share/flags.png) !important;
			}
			</style>
			<?php
		}
	}
}