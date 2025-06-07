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
				'default'     => __( 'Sign in', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Insert heading text here', 'unlock-elementor-widgets' ),
			]
		);

		// 2) Email Placeholder
		$this->add_control(
			'email_placeholder',
			[
				'label'       => __( 'Email Placeholder', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Email', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Insert email placeholder', 'unlock-elementor-widgets' ),
			]
		);

		// 3) Password Placeholder
		$this->add_control(
			'password_placeholder',
			[
				'label'       => __( 'Password Placeholder', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Password', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Insert password placeholder', 'unlock-elementor-widgets' ),
			]
		);

		// 4) Button Text
		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Login', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Insert button label', 'unlock-elementor-widgets' ),
			]
		);

		// 5) Redirect URL dopo login
		$this->add_control(
			'redirect_url',
			[
				'label'       => __( 'Redirect URL After Login', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'url',
				'placeholder' => __( 'e.g., /dashboard', 'unlock-elementor-widgets' ),
				'default'     => '/',
				'description' => __( 'Enter the URL to redirect to after successful login. Defaults to homepage (/).', 'unlock-elementor-widgets' ),
			]
		);

		// 6) Redirect URL if already logged in
		$this->add_control(
			'redirect_url_if_logged_in',
			[
				'label'       => __( 'Redirect URL If Already Logged In', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'url',
				'placeholder' => __( 'e.g., /account', 'unlock-elementor-widgets' ),
				'default'     => '/',
				'description' => __( 'If the user is already logged in, redirect to this URL. Defaults to homepage (/). This is handled by the JavaScript.', 'unlock-elementor-widgets' ),
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

		// Heading Color
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

		// Heading Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => __( 'Heading Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-heading',
			]
		);

		// Heading Alignment
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

		// Heading Margin
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

		// Input Background Color
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

		// Input Text Color
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

		// Input Border Color
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

		// Input Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => __( 'Input Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-input',
			]
		);

		// Input Padding
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

		// Input Margin Bottom
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

		// Button Text Color
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

		// Button Background Color
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

		// Button Border Radius
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

		// Button Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => __( 'Button Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-btn',
			]
		);

		// Button Padding
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

		// Button Margin
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
		$settings = $this->get_settings_for_display();
		$redirect_url_after_login = ! empty( $settings['redirect_url'] ) ? esc_url( $settings['redirect_url'] ) : '';
		$redirect_url_if_logged_in = ! empty( $settings['redirect_url_if_logged_in'] ) ? esc_url( $settings['redirect_url_if_logged_in'] ) : '';

		// Default English fallbacks if settings are empty
		$heading_text = ! empty( $settings['heading_text'] ) ? $settings['heading_text'] : 'Sign In';
		$email_placeholder = ! empty( $settings['email_placeholder'] ) ? $settings['email_placeholder'] : 'Email';
		$password_placeholder = ! empty( $settings['password_placeholder'] ) ? $settings['password_placeholder'] : 'Password';
		$button_text = ! empty( $settings['button_text'] ) ? $settings['button_text'] : 'Login';

		?>
		<style>
			.unlock-login-wrapper {
				max-width: 400px;
				margin: 2em auto;
				padding: 2em;
				background-color: #f9f9f9;
				border-radius: 8px;
				box-shadow: 0 4px 10px rgba(0,0,0,0.1);
				text-align: center;
			}
			.unlock-login-wrapper .unlock-heading {
				font-size: 1.8em;
				margin-bottom: 1em;
				color: #333;
			}
			.unlock-login-wrapper .unlock-form .unlock-input {
				width: 100%;
				padding: 0.8em;
				margin-bottom: 1em;
				border: 1px solid #ddd;
				border-radius: 4px;
				box-sizing: border-box;
				font-size: 1em;
			}
			.unlock-login-wrapper .unlock-form .unlock-input:focus {
				border-color: #0073aa;
				outline: none;
				box-shadow: 0 0 0 2px rgba(0,115,170,0.2);
			}
			.unlock-login-wrapper .unlock-form .unlock-btn {
				width: 100%;
				padding: 0.9em;
				background-color: #0073aa;
				color: white;
				border: none;
				border-radius: 4px;
				font-size: 1.1em;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}
			.unlock-login-wrapper .unlock-form .unlock-btn:hover {
				background-color: #005a87;
			}
			.unlock-login-wrapper .unlock-message {
				margin-top: 1em;
				padding: 0.75em;
				border-radius: 4px;
				font-size: 0.9em;
			}
			.unlock-login-wrapper .unlock-message.error {
				background-color: #f8d7da;
				color: #721c24;
				border: 1px solid #f5c6cb;
			}
			.unlock-login-wrapper .unlock-message.success {
				background-color: #d4edda;
				color: #155724;
				border: 1px solid #c3e6cb;
			}
			/* Responsive adjustments */
			@media (max-width: 480px) {
				.unlock-login-wrapper {
					margin: 1em;
					padding: 1.5em;
				}
				.unlock-login-wrapper .unlock-heading {
					font-size: 1.5em;
				}
			}
		</style>
		<div class="unlock-login-wrapper"
		     <?php if ( $redirect_url_after_login ) : ?>data-redirect-url="<?php echo $redirect_url_after_login; ?>"<?php endif; ?>
		     <?php if ( $redirect_url_if_logged_in ) : ?>data-redirect-url-if-logged-in="<?php echo $redirect_url_if_logged_in; ?>"<?php endif; ?>>
			
			<h3 class="unlock-heading elementor-inline-editing" data-elementor-setting-key="heading_text" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $heading_text ); ?></h3>

			<form id="unlock-login-form" class="unlock-form">
				<input
					type="email"
					id="unlock-login-email"
					class="unlock-input"
					placeholder="<?php echo esc_attr( $email_placeholder ); ?>"
					aria-label="<?php echo esc_attr( $email_placeholder ); ?>"
					required
				>

				<input
					type="password"
					id="unlock-login-password"
					class="unlock-input"
					placeholder="<?php echo esc_attr( $password_placeholder ); ?>"
					aria-label="<?php echo esc_attr( $password_placeholder ); ?>"
					required
				>

				<button type="submit" id="unlock-btn-login" class="unlock-btn elementor-inline-editing" data-elementor-setting-key="button_text" data-elementor-inline-editing-toolbar="basic">
					<?php echo esc_html( $button_text ); ?>
				</button>
			</form>

			<div id="unlock-login-message" class="unlock-message"></div>
		</div>
		<?php
	}
}
