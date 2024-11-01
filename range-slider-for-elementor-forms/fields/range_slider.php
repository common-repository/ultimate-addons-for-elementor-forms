<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Yeeaddons_Elementor_Range_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {
	private $fixed_files_indices = false;
	public function get_type() {
		return 'yeeaddons_range';
	}
	public function editor_preview_footer() {
		add_action( 'wp_footer', array($this,"telephone_content_template_script"));
	}
	function telephone_content_template_script(){
    ?>
    <script>
    jQuery( document ).ready( () => {
        elementor.hooks.addFilter(
            'elementor_pro/forms/content_template/field/range',
            function ( inputField, item, i ) {
                return `<input type="range" class="elementor-field-textual"/>`;
            }, 10, 3
        );
    });
    </script>
    <?php
}
	public function get_name() {
		return esc_html__( 'Range Slider', 'elementor-range-slider' );
	}
	/**
	 * @param Widget_Base $widget
	 */
	public function update_controls( $widget ) {
		$elementor = \ElementorPro\Plugin::elementor();
		$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );
		if ( is_wp_error( $control_data ) ) {
			return;
		}
		$field_controls = [
			'range_type' => [
				'name' => 'range_type',
				'label' => esc_html__( 'Type', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'single',
				'options'=>array("single"=>"single","double"=>"double"),
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'description' => esc_html__( 'Choose slider type, could be single - for one handle, or double for two handles', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_skin' => [
				'name' => 'range_skin',
				'label' => esc_html__( 'Skin', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'flat',
				'options'=>array("flat"=>"flat","big"=>"big","modern"=>"modern","round"=>"round","sharp"=>"sharp","square"=>"square"),
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'description' => esc_html__( 'Choose UI skin to use', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_min' => [
				'name' => 'range_min',
				'label' => esc_html__( 'Min', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '10',
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'description' => esc_html__( 'Set slider minimum value', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_max' => [
				'name' => 'range_max',
				'label' => esc_html__( 'Max', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '100',
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'description' => esc_html__( 'Set slider maximum value', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_from' => [
				'name' => 'range_from',
				'label' => esc_html__( 'From', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'min',
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'description' => esc_html__( 'Set start position for left handle (or for single handle)', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_to' => [
				'name' => 'range_to',
				'label' => esc_html__( 'To', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "max",
				'description' => esc_html__( 'Set start position for right handle', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_step' => [
				'name' => 'range_step',
				'label' => esc_html__( 'Step', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "1",
				'description'=> esc_html__('Set sliders step. Always > 0. Could be fractional','elementor-range-slider'),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_from_min' => [
				'name' => 'range_from_min',
				'label' => esc_html__( 'From min', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "min",
				'description' => esc_html__( 'Set minimum limit for left (or single) handle', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_from_max' => [
				'name' => 'range_from_max',
				'label' => esc_html__( 'From max', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "max",
				'description' => esc_html__( 'Set maximum limit for left (or single) handle', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_to_min' => [
				'name' => 'range_to_min',
				'label' => esc_html__( 'To min', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "min",
				'description' => esc_html__( 'Set minimum limit for right handle', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_to_max' => [
				'name' => 'range_to_max',
				'label' => esc_html__( 'To max', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "max",
				'description' => esc_html__( 'Set maximum limit for right handle', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			
			'range_prefix' => [
				'name' => 'range_prefix',
				'label' => esc_html__( 'Prefix ', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "",
				'description'=> esc_html__('Set prefix for values. Will be set up right before the number: **$**100','elementor-range-slider'),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_postfix' => [
				'name' => 'range_postfix',
				'label' => esc_html__( 'Postfix ', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "",
				'description'=> esc_html__('Set postfix for values. Will be set up right after the number: 100k','elementor-range-slider'),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'range_values' => [
				'name' => 'range_values',
				'label' => esc_html__( 'Custom values', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'description' => esc_html__('Format E.g: 1|3|5|6','elementor-range-slider'),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
			'grid_num' => [
				'name' => 'grid_num',
				'label' => esc_html__( 'Grid num', 'elementor-range-slider' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'default' => "4",
				'description' => esc_html__( 'Set number of grid cells', 'elementor-range-slider' ),
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
		];
		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
		$widget->update_control( 'form_fields', $control_data );
	}
	/**
	 * @param      $item
	 * @param      $item_index
	 * @param Form $form
	 */
	public function render( $item, $item_index, $form ) {	
		$form->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-range-slider elementor-field-textual' );
		$form->add_render_attribute( 'input' . $item_index, 'type', 'text', true );		
		$form->add_render_attribute( 'input' . $item_index, 'data-type', esc_attr( $item['range_type'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-skin', esc_attr( $item['range_skin'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-min', esc_attr( $item['range_min'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-max', esc_attr( $item['range_max'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-from', esc_attr( $item['range_from'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-from-min', esc_attr( $item['range_from_min'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-from-max', esc_attr( $item['range_from_max'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-to', esc_attr( $item['range_to'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-to-min', esc_attr( $item['range_to_min'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-to-max', esc_attr( $item['range_to_max'] ) );
		$form->add_render_attribute( 'input' . $item_index, 'data-step', esc_attr( $item['range_step'] )  );
		$form->add_render_attribute( 'input' . $item_index, 'data-prefix', esc_attr( $item['range_prefix'] )  );
		$form->add_render_attribute( 'input' . $item_index, 'data-postfix', esc_attr( $item['range_postfix'] )  );
		$form->add_render_attribute( 'input' . $item_index, 'data-grid-num', esc_attr( $item['grid_num'] )  );
		$form->add_render_attribute( 'input' . $item_index, 'data-grid', "true"  );
		$values = $item['range_values'];
		if( $values != "" ){
			$datas = explode("|",$values);
			$text = implode(", ",$datas);
			$form->add_render_attribute( 'input' . $item_index, 'data-values', $text );
		}
		?>
		<input <?php $form->print_render_attribute_string( 'input' . $item_index ); ?> >
		<?php
	}
	public function __construct() {
		parent::__construct();
		add_action("wp_enqueue_scripts",array($this,"add_lib"),1000);
		add_action( 'elementor/preview/init', array( $this, 'editor_preview_footer' ) );
	}
	function add_lib(){
		wp_enqueue_script("ionrangeslider",YEEADDONS_ELEMENTOR_RANGE_SLIDER_PLUGIN_URL."libs/ionrangeslider/js/ion.rangeSlider.min.js",array("jquery"));
        wp_enqueue_script("elementor_range_slider",YEEADDONS_ELEMENTOR_RANGE_SLIDER_PLUGIN_URL."libs/elementor_range_slider.js",array("jquery"));
        wp_enqueue_style("ionrangeslider",YEEADDONS_ELEMENTOR_RANGE_SLIDER_PLUGIN_URL."libs/ionrangeslider/css/ion.rangeSlider.min.css");
	}
}
