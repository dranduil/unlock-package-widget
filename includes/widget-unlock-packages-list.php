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

		$this->add_control(
			'list_title',
			[
				'label' => __( 'Title', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Packages available', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Enter your title', 'unlock-elementor-widgets' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'pkg_name',
			[
				'label' => __( 'Package Name', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Demo Package', 'unlock-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'pkg_description',
			[
				'label' => __( 'Description', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'This is a great demo package.', 'unlock-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'pkg_price',
			[
				'label' => __( 'Price', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'AED 10', 'unlock-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'pkg_image',
			[
				'label' => __( 'Image', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'pkg_features',
			[
				'label' => __( 'Features (one per line)', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( "Feature A\nFeature B", 'unlock-elementor-widgets' ),
				'placeholder' => __( "Feature 1\nFeature 2", 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'packages_list_items',
			[
				'label' => __( 'Packages', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'pkg_name' => __( 'Demo Package 1', 'unlock-elementor-widgets' ),
						'pkg_description' => __( 'This is a great demo package.', 'unlock-elementor-widgets' ),
						'pkg_price' => __( 'AED 10', 'unlock-elementor-widgets' ),
						'pkg_features' => __( "Feature A\nFeature B", 'unlock-elementor-widgets' ),
						'pkg_image' => ['url' => 'https://via.placeholder.com/150'],
					],
					[
						'pkg_name' => __( 'Demo Package 2', 'unlock-elementor-widgets' ),
						'pkg_description' => __( 'Another excellent demo package.', 'unlock-elementor-widgets' ),
						'pkg_price' => __( 'AED 20', 'unlock-elementor-widgets' ),
						'pkg_features' => __( "Feature C\nFeature D\nFeature E", 'unlock-elementor-widgets' ),
						'pkg_image' => ['url' => 'https://via.placeholder.com/150'],
					],
				],
				'title_field' => '{{{ pkg_name }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="unlock-packages-wrapper">
			<h3 class="unlock-heading"><?php echo esc_html( $settings['list_title'] ); ?></h3>
			<div id="unlock-packages-list">
				<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<?php if ( ! empty( $settings['packages_list_items'] ) ) : ?>
						<?php foreach ( $settings['packages_list_items'] as $index => $item ) : ?>
							<div class="unlock-package-card" data-id="demo-<?php echo esc_attr( $index ); ?>">
								<?php if ( ! empty( $item['pkg_image']['url'] ) ) : ?>
									<img src="<?php echo esc_url( $item['pkg_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['pkg_name'] ); ?>" class="unlock-package-image" style="width:100%;max-width:150px;height:auto;margin-bottom:10px;">
								<?php endif; ?>
								<h4 class="unlock-package-name"><?php echo esc_html( $item['pkg_name'] ); ?></h4>
								<p class="unlock-package-desc"><?php echo nl2br( esc_html( $item['pkg_description'] ) ); ?></p>
								<p class="unlock-package-price"><?php echo esc_html( $item['pkg_price'] ); ?></p>
								<?php if ( ! empty( $item['pkg_features'] ) ) : ?>
									<ul>
										<?php
										$features = explode( "\n", $item['pkg_features'] );
										foreach ( $features as $feature ) :
											?>
											<li><?php echo esc_html( trim( $feature ) ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<button class="unlock-buy-btn" data-id="demo-<?php echo esc_attr( $index ); ?>">Acquista</button>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<p><?php esc_html_e( 'No packages configured. Please add packages in the editor.', 'unlock-elementor-widgets' ); ?></p>
					<?php endif; ?>
				<?php else : ?>
					<p><?php esc_html_e( 'Loading Packages…', 'unlock-elementor-widgets' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
