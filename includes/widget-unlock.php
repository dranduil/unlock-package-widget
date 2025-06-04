<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class unlock_Widget_Elementor extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unlock_widget';
	}

	public function get_title() {
		return 'unlock Pack & Login';
	}

	public function get_icon() {
		return 'eicon-lock-user'; // any Elementor icon you like
	}

	public function get_categories() {
		return [ 'general' ];
	}

	// If you had style dependencies, you’d enqueue them in this method.
	public function get_script_depends() {
		return [ 'unlock-widget-js' ];
	}

	// 1) Register any controls you want to expose in the editor.
	public function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'unlock Settings', 'unlock-package-widget' ),
			]
		);

		// Example: allow user to hide “Registration” or “Login” blocks if they want
		$this->add_control(
			'show_login',
			[
				'label'       => __( 'Show Login Form', 'unlock-package-widget' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => __( 'Show', 'unlock-package-widget' ),
				'label_off'   => __( 'Hide', 'unlock-package-widget' ),
				'return_value'=> 'yes',
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'show_register',
			[
				'label'       => __( 'Show Registration Form', 'unlock-package-widget' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => __( 'Show', 'unlock-package-widget' ),
				'label_off'   => __( 'Hide', 'unlock-package-widget' ),
				'return_value'=> 'yes',
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'show_packages',
			[
				'label'       => __( 'Show Packages', 'unlock-package-widget' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => __( 'Show', 'unlock-package-widget' ),
				'label_off'   => __( 'Hide', 'unlock-package-widget' ),
				'return_value'=> 'yes',
				'default'     => 'yes',
			]
		);

		$this->end_controls_section();

		// 2) (Optional) Style tab: let them style container colors, button typography, etc.
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'unlock-package-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Heading Color', 'unlock-package-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Button Text Color', 'unlock-package-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	// 3) Render the HTML output on the frontend (with IDs/classes that our JS expects).
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Decide which blocks to show based on controls:
		$show_login     = filter_var( $settings['show_login'], FILTER_VALIDATE_BOOLEAN );
		$show_register  = filter_var( $settings['show_register'], FILTER_VALIDATE_BOOLEAN );
		$show_packages  = filter_var( $settings['show_packages'], FILTER_VALIDATE_BOOLEAN );
		?>

		<div class="unlock-widget-wrapper">
			<?php if ( $show_login ) : ?>
				<div id="unlock-login-block">
					<h3 class="unlock-heading"><?php esc_html_e( 'Login', 'unlock-package-widget' ); ?></h3>
					<input type="text" id="login_email" class="unlock-input" placeholder="<?php esc_attr_e( 'Email', 'unlock-package-widget' ); ?>"><br>
					<input type="password" id="login_password" class="unlock-input" placeholder="<?php esc_attr_e( 'Password', 'unlock-package-widget' ); ?>"><br>
					<button id="btn_login" class="unlock-btn"><?php esc_html_e( 'Login', 'unlock-package-widget' ); ?></button>
				</div>
			<?php endif; ?>

			<?php if ( $show_register ) : ?>
				<div id="unlock-register-block" style="margin-top:20px;">
					<h3 class="unlock-heading"><?php esc_html_e( 'Register', 'unlock-package-widget' ); ?></h3>
					<input type="text" id="register_email" class="unlock-input" placeholder="<?php esc_attr_e( 'Email', 'unlock-package-widget' ); ?>"><br>
					<input type="password" id="register_password" class="unlock-input" placeholder="<?php esc_attr_e( 'Password', 'unlock-package-widget' ); ?>"><br>
					<button id="btn_register" class="unlock-btn"><?php esc_html_e( 'Register', 'unlock-package-widget' ); ?></button>
				</div>
			<?php endif; ?>

			<?php if ( $show_packages ) : ?>
				<div id="unlock-packages-block" style="margin-top:30px;">
					<h3 class="unlock-heading"><?php esc_html_e( 'Available Packages', 'unlock-package-widget' ); ?></h3>
					<div id="package_container">
						<p><?php esc_html_e( 'Loading packages…', 'unlock-package-widget' ); ?></p>
					</div>
				</div>
			<?php endif; ?>

			<div id="unlock-user-info" style="display:none; margin-top:20px;"></div>
		</div>

		<?php
	}
}
