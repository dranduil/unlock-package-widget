<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Unlock_Widget_Login extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unlock_login';
	}

	public function get_title() {
		return 'unlock Login';
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
		// Se vuoi, puoi aggiungere controlli (es. testi dei placeholder) nel pannello Style/Content.
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Unlock Login Settings', 'unlock-elementor-widgets' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		?>
		<div class="unlock-login-wrapper">
			<h3 class="unlock-heading"><?php esc_html_e( 'Accedi', 'unlock-elementor-widgets' ); ?></h3>
			<input type="email" id="unlock-login-email" class="unlock-input" placeholder="<?php esc_attr_e( 'Email', 'unlock-elementor-widgets' ); ?>"><br>
			<input type="password" id="unlock-login-password" class="unlock-input" placeholder="<?php esc_attr_e( 'Password', 'unlock-elementor-widgets' ); ?>"><br>
			<button id="unlock-btn-login" class="unlock-btn"><?php esc_html_e( 'Login', 'unlock-elementor-widgets' ); ?></button>
			<div id="unlock-login-message" class="unlock-message" style="margin-top:10px;"></div>
		</div>
		<?php
	}
}
