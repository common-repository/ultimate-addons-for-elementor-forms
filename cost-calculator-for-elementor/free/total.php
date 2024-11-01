<?php
class Total_Format_Cost_Calculator_Widget extends \Elementor\Widget_Base{
	public function get_name() {
		return 'total_input';
	}
	/**
	 * Get widget title.
	 *
	 * Retrieve currency widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Calculator total', 'cost-calculator-for-elementor' );
	}
	/**
	 * Get widget icon.
	 *
	 * Retrieve currency widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-number-field';
	}
	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://calculator.add-ons.org/';
	}
	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the currency widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}
	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the currency widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'currency', 'currencies','number','calculator','cost','formula','total' ];
	}
	/**
	 * Register currency widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'cost-calculator-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'cost-calculator-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'total-change_name',
			]
		);
		$this->add_control(
			'formula',
			[
				'label' => esc_html__( 'Formula', 'cost-calculator-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'description' => 'Name input: number-1 + number-2 - 999'
			]
		);
		$this->add_control(
			'number_format',
			[
				'label' => esc_html__( 'Currency', 'cost-calculator-for-elementor' ),
				'type' =>  \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);
		$this->add_control(
			'number_format_symbols',
			[
				'name' => 'number_format_symbols',
				'label' => esc_html__( 'Symbols', 'cost-calculator-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'number_format' => 'yes'
				],
			]
		);
		$this->add_control(
			'number_format_symbols_position',
			[
				'name' => 'number_format_symbols_position',
				'label' => esc_html__( 'Symbols Position', 'cost-calculator-for-elementor' ),
				'options'=> array("left"=>"Left","right"=>"Right"),
				'default' => 'left',
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [
					'number_format' => 'yes'
				],
			]
		);
		$this->add_control(
			'number_format_thousand_sep',
			[
				'name' => 'number_format_thousand_sep',
				'label' => esc_html__( 'Thousand separator', 'cost-calculator-for-elementor' ),
				'default' => ',',
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'number_format' => 'yes'
				],
			]
		);
		$this->add_control(
			'number_format_decimal_sep',
			[
				'name' => 'number_format_decimal_sep',
				'label' => esc_html__( 'Decimal separator', 'cost-calculator-for-elementor' ),
				'default' => '.',
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'number_format' => 'yes'
				],
			]
		);
		$this->add_control(
			'number_format_num_decimals',
			[
				'name' => 'number_format_num_decimals',
				'label' => esc_html__( 'Number Decimals', 'cost-calculator-for-elementor' ),
				'default' => 2,
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'number_format' => 'yes'
				],
			]
		);
		$this->end_controls_section();
	}
	/**
	 * Render currency widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$name = $settings["name"];
		$atts = "";
		$class = "elementor-total ";
		if( $settings["number_format"] == "yes" ){
			$class .="elementor-number-format";
			$atts .='data-a-sign="'.$settings["number_format_symbols"].'" ';
			$atts .='data-a-dec="'.$settings["number_format_decimal_sep"].'" ';
			$atts .='data-a-sep="'.$settings["number_format_thousand_sep"].'" ';
			$atts .='data-m-dec="'.$settings["number_format_num_decimals"].'" ';
			if( $settings['number_format_symbols_position'] == "right" ){
				$atts .='data-p-sign="s" ';
			}
		}
				?>
		<input readonly="readonly" data-formula="<?php echo $settings["formula"]  ?>" <?php echo ($atts) ?> class="<?php echo esc_attr($class) ?>" type="text" name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
		<?php
	}
}