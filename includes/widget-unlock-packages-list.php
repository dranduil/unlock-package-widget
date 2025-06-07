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
				<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<?php
					$demo_packages = [
						['id' => 1, 'name' => 'Demo Package 1', 'description' => 'This is a great demo package.', 'price' => 'AED 10', 'features' => ['Feature A', 'Feature B'], 'image_url' => 'https://via.placeholder.com/150'],
						['id' => 2, 'name' => 'Demo Package 2', 'description' => 'Another excellent demo package.', 'price' => 'AED 20', 'features' => ['Feature C', 'Feature D', 'Feature E'], 'image_url' => 'https://via.placeholder.com/150'],
						['id' => 3, 'name' => 'Demo Package 3', 'description' => 'The best demo package ever.', 'price' => 'AED 30', 'features' => ['Feature F'], 'image_url' => 'https://via.placeholder.com/150'],
					];
					?>
					<?php foreach ( $demo_packages as $pkg ) : ?>
						<div class="unlock-package-card" data-id="<?php echo esc_attr( $pkg['id'] ); ?>">
                            <img src="<?php echo esc_url( $pkg['image_url'] ); ?>" alt="<?php echo esc_attr( $pkg['name'] ); ?>" class="unlock-package-image" style="width:100%;max-width:150px;height:auto;margin-bottom:10px;">
							<h4 class="unlock-package-name"><?php echo esc_html( $pkg['name'] ); ?></h4>
							<p class="unlock-package-desc"><?php echo esc_html( $pkg['description'] ); ?></p>
							<p class="unlock-package-price"><?php echo esc_html( $pkg['price'] ); ?></p>
							<ul>
								<?php foreach ( $pkg['features'] as $feature ) : ?>
									<li><?php echo esc_html( $feature ); ?></li>
								<?php endforeach; ?>
							</ul>
							<button class="unlock-buy-btn" data-id="<?php echo esc_attr( $pkg['id'] ); ?>">Acquista</button>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<p><?php esc_html_e( 'Loading Packages…', 'unlock-elementor-widgets' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
