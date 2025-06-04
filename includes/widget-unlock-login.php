<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Unlock_Widget_Login extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unlock_login';
	}

	public function get_title() {
		return __( 'Unlock Login', 'unlock-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-lock-user';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_script_depends() {
		return [ 'unlock-widgets-js' ];
	}

	protected function _register_controls() {
		// ───── CONTENT TAB ─────
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'unlock-elementor-widgets' ),
			]
		);

		// 1) Heading Text
		$this->add_control(
			'heading_text',
			[
				'label'       => __( 'Heading Text', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Accedi', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Inserisci il testo dell’intestazione', 'unlock-elementor-widgets' ),
			]
		);

		// 2) Email Placeholder
		$this->add_control(
			'email_placeholder',
			[
				'label'       => __( 'Email Placeholder', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Email', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Inserisci il placeholder per Email', 'unlock-elementor-widgets' ),
			]
		);

		// 3) Password Placeholder
		$this->add_control(
			'password_placeholder',
			[
				'label'       => __( 'Password Placeholder', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Password', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Inserisci il placeholder per Password', 'unlock-elementor-widgets' ),
			]
		);

		// 4) Button Text
		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Login', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Inserisci il testo del pulsante', 'unlock-elementor-widgets' ),
			]
		);

		// 5) Redirect URL dopo login
		$this->add_control(
			'redirect_url',
			[
				'label'       => __( 'Redirect After Login', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://tuosito.it/pagina-di-redirect', 'unlock-elementor-widgets' ),
				'description' => __( 'Lascia vuoto per non reindirizzare', 'unlock-elementor-widgets' ),
			]
		);

		$this->end_controls_section();

		// ───── STYLE TAB: Heading ─────
		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => __( 'Heading', 'unlock-elementor-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// 1) Heading Color
		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Heading Color', 'unlock-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222222',
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'color: {{VALUE}};',
				],
			]
		);

		// 2) Heading Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => __( 'Heading Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-heading',
			]
		);

		// 3) Heading Alignment
		$this->add_control(
			'heading_alignment',
			[
				'label'   => __( 'Heading Alignment', 'unlock-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => __( 'Left', 'unlock-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'unlock-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'unlock-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		// 4) Heading Margin (Box Control)
		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => __( 'Heading Margin', 'unlock-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .unlock-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ───── STYLE TAB: Input Fields ─────
		$this->start_controls_section(
			'section_style_input',
			[
				'label' => __( 'Input Fields', 'unlock-elementor-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// 1) Input Background Color
		$this->add_control(
			'input_background',
			[
				'label'     => __( 'Input Background Color', 'unlock-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .unlock-input' => 'background-color: {{VALUE}};',
				],
			]
		);

		// 2) Input Text Color
		$this->add_control(
			'input_text_color',
			[
				'label'     => __( 'Input Text Color', 'unlock-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222222',
				'selectors' => [
					'{{WRAPPER}} .unlock-input' => 'color: {{VALUE}};',
				],
			]
		);

		// 3) Input Border Color
		$this->add_control(
			'input_border_color',
			[
				'label'     => __( 'Input Border Color', 'unlock-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => [
					'{{WRAPPER}} .unlock-input' => 'border-color: {{VALUE}};',
				],
			]
		);

		// 4) Input Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => __( 'Input Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-input',
			]
		);

		// 5) Input Padding (Box Control)
		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => __( 'Input Padding', 'unlock-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .unlock-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// 6) Input Margin Bottom
		$this->add_responsive_control(
			'input_margin',
			[
				'label'      => __( 'Input Margin (Bottom)', 'unlock-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .unlock-input' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ───── STYLE TAB: Button ─────
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button', 'unlock-elementor-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// 1) Button Text Color
		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Button Text Color', 'unlock-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .unlock-btn' => 'color: {{VALUE}};',
				],
			]
		);

		// 2) Button Background Color
		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Button Background Color', 'unlock-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0073aa',
				'selectors' => [
					'{{WRAPPER}} .unlock-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		// 3) Button Border Radius
		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Button Border Radius', 'unlock-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .unlock-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// 4) Button Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => __( 'Button Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-btn',
			]
		);

		// 5) Button Padding
		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Button Padding', 'unlock-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .unlock-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// 6) Button Margin (Box Control)
		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => __( 'Button Margin', 'unlock-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .unlock-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$redirect_url = ( ! empty( $settings['redirect_url']['url'] ) ) ? esc_url( $settings['redirect_url']['url'] ) : '';
		?>
		<div class="unlock-login-wrapper"
		     <?php if ( $redirect_url ) : ?>data-redirect-url="<?php echo $redirect_url; ?>"<?php endif; ?>>
			<?php if ( ! empty( $settings['heading_text'] ) ) : ?>
				<h3 class="unlock-heading">
					<?php echo esc_html( $settings['heading_text'] ); ?>
				</h3>
			<?php endif; ?>

			<form id="unlock-login-form" class="unlock-form">
				<input
					type="email"
					id="unlock-login-email"
					class="unlock-input"
					placeholder="<?php echo esc_attr( $settings['email_placeholder'] ); ?>"
					required
				><br>

				<input
					type="password"
					id="unlock-login-password"
					class="unlock-input"
					placeholder="<?php echo esc_attr( $settings['password_placeholder'] ); ?>"
					required
				><br>

				<button type="submit" id="unlock-btn-login" class="unlock-btn">
					<?php echo esc_html( $settings['button_text'] ); ?>
				</button>
			</form>

			<div id="unlock-login-message" class="unlock-message" style="margin-top:10px;"></div>
		</div>
		<?php
	}
}