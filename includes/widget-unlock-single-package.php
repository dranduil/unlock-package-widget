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
				<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<?php
					$demo_pkg = ['id' => $pkg_id ?: 'demo', 'name' => 'Demo Single Package', 'description' => 'Detailed description of this amazing demo package.', 'price' => 'AED 25', 'features' => ['Exclusive Feature X', 'Exclusive Feature Y'], 'image_url' => 'https://via.placeholder.com/250'];
					?>
					<div class="unlock-package-card" data-id="<?php echo esc_attr( $demo_pkg['id'] ); ?>">
                        <img src="<?php echo esc_url( $demo_pkg['image_url'] ); ?>" alt="<?php echo esc_attr( $demo_pkg['name'] ); ?>" class="unlock-package-image" style="width:100%;max-width:250px;height:auto;margin-bottom:10px;">
						<h4 class="unlock-package-name"><?php echo esc_html( $demo_pkg['name'] ); ?></h4>
						<p class="unlock-package-desc"><?php echo esc_html( $demo_pkg['description'] ); ?></p>
						<p class="unlock-package-price"><?php echo esc_html( $demo_pkg['price'] ); ?></p>
						<ul>
							<?php foreach ( $demo_pkg['features'] as $feature ) : ?>
								<li><?php echo esc_html( $feature ); ?></li>
							<?php endforeach; ?>
						</ul>
						<button class="unlock-buy-btn" data-id="<?php echo esc_attr( $demo_pkg['id'] ); ?>">Acquista</button>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'Caricamento dettagli…', 'unlock-elementor-widgets' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
