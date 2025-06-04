<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Unlock_Widget_Single_Package extends \Elementor\Widget_Base {

	public function get_name() {
		return 'unlock_single_package';
	}

	public function get_title() {
		return 'Unlock Single Package';
	}

	public function get_icon() {
		return 'eicon-post';
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
				'label' => __( 'Single Package Settings', 'unlock-elementor-widgets' ),
			]
		);
		$this->add_control(
			'package_id',
			[
				'label' => __( 'ID Pacchetto', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'Inserisci l\'ID del pacchetto da mostrare', 'unlock-elementor-widgets' ),
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$pkg_id = esc_attr( $settings['package_id'] );
		?>
		<div class="unlock-single-package-wrapper">
			<h3 class="unlock-heading"><?php esc_html_e( 'Dettaglio Pacchetto', 'unlock-elementor-widgets' ); ?></h3>
			<div id="unlock-single-package-<?php echo $pkg_id; ?>" data-package-id="<?php echo $pkg_id; ?>">
				<p><?php esc_html_e( 'Caricamento dettagli…', 'unlock-elementor-widgets' ); ?></p>
			</div>
		</div>
		<?php
	}
}
