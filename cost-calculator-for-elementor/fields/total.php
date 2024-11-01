<?php
namespace ElementorPro\Modules\Forms\Fields;
use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Classes;
use Elementor\Controls_Manager;
use ElementorPro\Plugin;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Cost_Calculator extends Field_Base {
	public function get_type() {
		return 'calculator';
	}
	public function get_name() {
		return esc_html__( 'Calculator', 'cost-calculator-for-elementor' );
	}
	public function __construct() {
		parent::__construct();
		add_action( 'elementor/preview/init', array( $this, 'editor_preview_footer' ) );
	}
	public function editor_preview_footer() {
		add_action( 'wp_footer', array($this,"field_template_script"));
	}
	function field_template_script(){
	    ?>
	    <script>
	    jQuery( document ).ready( () => {
	         elementor.hooks.addFilter(
                'elementor_pro/forms/content_template/field/calculator',
                function ( inputField, item, i ) {
                    const fieldId    = `form_field_${i}`;
                    const fieldClass = `elementor-field elementor-size-sm elementor-field-textual ${item.css_classes}`;
                    const size       = '1';
                    return `<input  placeholder="Total"  type="text" id="${fieldId}" class="${fieldClass}">`;
                }, 10, 3
            );
	    });
	    </script>
	    <?php
	}
	public function render( $item, $item_index, $form ) {
		$form->remove_render_attribute( 'input' . $item_index, 'type' );
		$form->add_render_attribute( 'input' . $item_index, 'type', 'text' );
		$form->add_render_attribute( 'input' . $item_index, 'readonly', 'readonly' );
		$form->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual elementor-field-calculator' );
		if ( isset( $item['formula'] ) ) {
			$form->add_render_attribute( 'input' . $item_index, 'data-formula', esc_attr( $item['formula'] ) );
		}
		if ( isset( $item['number_format'] ) && $item['number_format'] =="yes" ) {
			$form->add_render_attribute( 'input' . $item_index, 'class', 'elementor-number-format' );
			$form->add_render_attribute( 'input' . $item_index, 'data-a-sign', esc_attr( $item['number_format_symbols'] ) );
			$form->add_render_attribute( 'input' . $item_index, 'data-a-dec', esc_attr( $item['number_format_decimal_sep'] ) );
			$form->add_render_attribute( 'input' . $item_index, 'data-a-sep', esc_attr( $item['number_format_thousand_sep'] ) );
			$form->add_render_attribute( 'input' . $item_index, 'data-m-dec', esc_attr( $item['number_format_num_decimals'] ) );
			if( $item['number_format_symbols_position'] == "right" ){
				$form->add_render_attribute( 'input' . $item_index, 'data-p-sign', 's');
			}
			
		}
		?>
			<input <?php $form->print_render_attribute_string( 'input' . $item_index ); ?> >
		<?php
	}
	/**
	 * @param Widget_Base $widget
	 */
	public function update_controls( $widget ) {
		$elementor = Plugin::elementor();
		$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );
		if ( is_wp_error( $control_data ) ) {
			return;
		}
		$check = get_option( '_redmuber_item_1529');
		if($check == "ok") {
			$field_controls = [
				'formula' => [
					'name' => 'formula',
					'label' => esc_html__( 'Formula', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXTAREA,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format' => [
					'name' => 'number_format',
					'label' => esc_html__( 'Number Format', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_symbols' => [
					'name' => 'number_format_symbols',
					'label' => esc_html__( 'Symbols', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'dynamic' => [
						'active' => true,
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_symbols_position' => [
					'name' => 'number_format_symbols_position',
					'label' => esc_html__( 'Symbols Position', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options'=> array("left"=>"Left","right"=>"Right"),
					'default' => 'left',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_thousand_sep' => [
					'name' => 'number_format_thousand_sep',
					'label' => esc_html__( 'Thousand separator', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => ',',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_decimal_sep' => [
					'name' => 'number_format_decimal_sep',
					'label' => esc_html__( 'Decimal separator', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => '.',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_num_decimals' => [
					'name' => 'number_format_num_decimals',
					'label' => esc_html__( 'Number Decimals', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 2,
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
			];
		}else{
			$field_controls = [
				'formula' => [
					'name' => 'formula',
					'label' => esc_html__( 'Formula', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXTAREA,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format' => [
					'name' => 'number_format',
					'label' => esc_html__( 'Number Format', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'field_type' => $this->get_type(),
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_symbols_disable' => [
					'name' => 'number_format_symbols_disable',
					'label' => esc_html__( 'Symbols (pro)', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'class' => 'd',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'dynamic' => [
						'active' => true,
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_symbols_position_disable' => [
					'name' => 'number_format_symbols_position_disable',
					'label' => esc_html__( 'Symbols Position (pro)', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options'=> array("left"=>"Left","right"=>"Right"),
					'default' => 'left',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_thousand_sep_disable' => [
					'name' => 'number_format_thousand_sep_disable',
					'label' => esc_html__( 'Thousand separator (pro)', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => ',',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_decimal_sep_disable' => [
					'name' => 'number_format_decimal_sep_disable',
					'label' => esc_html__( 'Decimal separator (pro)', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => '.',
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
				'number_format_num_decimals_disable' => [
					'name' => 'number_format_num_decimals_disable',
					'label' => esc_html__( 'Number Decimals (pro)', 'cost-calculator-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 2,
					'condition' => [
						'field_type' => $this->get_type(),
						'number_format' => 'yes'
					],
					'tab' => 'content',
					'inner_tab' => 'form_fields_content_tab',
					'tabs_wrapper' => 'form_fields_tabs',
				],
			];
		}
		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
		$widget->update_control( 'form_fields', $control_data );
	}
}
new Cost_Calculator;