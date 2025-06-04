<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Unlock_Widget_Signup extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unlock_signup';
	}

	public function get_title() {
		return 'Unlock Signup';
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_script_depends() {
		return [ 'unlock-widgets-js' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Unlock Signup Settings', 'unlock-elementor-widgets' ),
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		?>
		<div class="unlock-signup-wrapper">
			<h3 class="unlock-heading"><?php esc_html_e( 'Registrati', 'unlock-elementor-widgets' ); ?></h3>
			<input type="email" id="unlock-signup-email" class="unlock-input" placeholder="<?php esc_attr_e( 'Email', 'unlock-elementor-widgets' ); ?>"><br>
			<input type="password" id="unlock-signup-password" class="unlock-input" placeholder="<?php esc_attr_e( 'Password', 'unlock-elementor-widgets' ); ?>"><br>
			<button id="unlock-btn-signup" class="unlock-btn"><?php esc_html_e( 'Sign Up', 'unlock-elementor-widgets' ); ?></button>
			<div id="unlock-signup-message" class="unlock-message" style="margin-top:10px;"></div>
		</div>
		<?php
	}
}
