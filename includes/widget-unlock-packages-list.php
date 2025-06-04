<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Unlock_Widget_Packages_List extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unlock_packages_list';
	}

	public function get_title() {
		return 'Unlock Packages List';
	}

	public function get_icon() {
		return 'eicon-posts-grid';
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
				'label' => __( 'Packages List Settings', 'unlock-elementor-widgets' ),
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		?>
		<div class="unlock-packages-wrapper">
			<h3 class="unlock-heading"><?php esc_html_e( 'Packages available', 'unlock-elementor-widgets' ); ?></h3>
			<div id="unlock-packages-list">
				<p><?php esc_html_e( 'Loading Packages…', 'unlock-elementor-widgets' ); ?></p>
			</div>
		</div>
		<?php
	}
}
