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
				'label' => __( 'Package ID (for live data)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'Enter the ID of the package to display on the live site. The settings below are for editor preview only.', 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'widget_title',
			[
				'label' => __( 'Widget Title (Editor Preview)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Dettaglio Pacchetto', 'unlock-elementor-widgets' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pkg_name_editor',
			[
				'label' => __( 'Package Name (Editor Preview)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Demo Single Package', 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'pkg_description_editor',
			[
				'label' => __( 'Description (Editor Preview)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Detailed description of this amazing demo package.', 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'pkg_price_editor',
			[
				'label' => __( 'Price (Editor Preview)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'AED 25', 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'pkg_image_editor',
			[
				'label' => __( 'Image (Editor Preview)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/250',
				],
			]
		);

		$this->add_control(
			'pkg_features_editor',
			[
				'label' => __( 'Features (Editor Preview, one per line)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( "Exclusive Feature X\nExclusive Feature Y", 'unlock-elementor-widgets' ),
				'placeholder' => __( "Feature 1\nFeature 2", 'unlock-elementor-widgets' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$pkg_id_live = esc_attr( $settings['package_id'] ); // Used for live site
		$editor_pkg_id = $pkg_id_live ?: 'editor-preview'; // ID for editor preview

		?>
		<div class="unlock-single-package-wrapper">
			<h3 class="unlock-heading">
				<?php 
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					echo esc_html( $settings['widget_title'] );
				} else {
					esc_html_e( 'Dettaglio Pacchetto', 'unlock-elementor-widgets' );
				}
				?>
			</h3>
			<div id="unlock-single-package-<?php echo $pkg_id_live ? $pkg_id_live : $editor_pkg_id; ?>" data-package-id="<?php echo $pkg_id_live; ?>">
				<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<div class="unlock-package-card" data-id="<?php echo esc_attr( $editor_pkg_id ); ?>">
						<?php if ( ! empty( $settings['pkg_image_editor']['url'] ) ) : ?>
							<img src="<?php echo esc_url( $settings['pkg_image_editor']['url'] ); ?>" alt="<?php echo esc_attr( $settings['pkg_name_editor'] ); ?>" class="unlock-package-image" style="width:100%;max-width:250px;height:auto;margin-bottom:10px;">
						<?php endif; ?>
						<h4 class="unlock-package-name"><?php echo esc_html( $settings['pkg_name_editor'] ); ?></h4>
						<p class="unlock-package-desc"><?php echo nl2br( esc_html( $settings['pkg_description_editor'] ) ); ?></p>
						<p class="unlock-package-price"><?php echo esc_html( $settings['pkg_price_editor'] ); ?></p>
						<?php if ( ! empty( $settings['pkg_features_editor'] ) ) : ?>
							<ul>
								<?php
								$features = explode( "\n", $settings['pkg_features_editor'] );
								foreach ( $features as $feature ) :
									?>
									<li><?php echo esc_html( trim( $feature ) ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<button class="unlock-buy-btn" data-id="<?php echo esc_attr( $editor_pkg_id ); ?>">Acquista</button>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'Caricamento dettagli…', 'unlock-elementor-widgets' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
