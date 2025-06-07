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

		// Style Tab
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'unlock-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-heading',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Title Margin', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_style_heading',
			[
				'label' => __( 'Package Card', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'card_background',
				'label' => __( 'Card Background', 'unlock-elementor-widgets' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .unlock-package-card',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => __( 'Card Padding', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-package-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => __( 'Card Border', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-package-card',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label' => __( 'Border Radius', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-package-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_box_shadow',
				'label' => __( 'Card Box Shadow', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-package-card',
			]
		);

		// Package Name Styling
		$this->add_control(
			'pkg_name_style_heading',
			[
				'label' => __( 'Package Name', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pkg_name_typography',
				'label' => __( 'Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-package-name',
			]
		);

		$this->add_control(
			'pkg_name_color',
			[
				'label' => __( 'Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-package-name' => 'color: {{VALUE}}',
				],
			]
		);

		// Package Description Styling
		$this->add_control(
			'pkg_desc_style_heading',
			[
				'label' => __( 'Package Description', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pkg_desc_typography',
				'label' => __( 'Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-package-desc',
			]
		);

		$this->add_control(
			'pkg_desc_color',
			[
				'label' => __( 'Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-package-desc' => 'color: {{VALUE}}',
				],
			]
		);

		// Package Price Styling
		$this->add_control(
			'pkg_price_style_heading',
			[
				'label' => __( 'Package Price', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pkg_price_typography',
				'label' => __( 'Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-package-price',
			]
		);

		$this->add_control(
			'pkg_price_color',
			[
				'label' => __( 'Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-package-price' => 'color: {{VALUE}}',
				],
			]
		);

		// Package Features Styling
		$this->add_control(
			'pkg_features_style_heading',
			[
				'label' => __( 'Package Features', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pkg_features_typography',
				'label' => __( 'Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-package-card ul li',
			]
		);

		$this->add_control(
			'pkg_features_color',
			[
				'label' => __( 'Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-package-card ul li' => 'color: {{VALUE}}',
				],
			]
		);

		// Button Styling
		$this->add_control(
			'button_style_heading',
			[
				'label' => __( 'Button', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-buy-btn',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => __( 'Normal', 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-buy-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'label' => __( 'Background', 'unlock-elementor-widgets' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .unlock-buy-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => __( 'Border', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-buy-btn',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-buy-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-buy-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => __( 'Hover', 'unlock-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-buy-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_hover_background',
				'label' => __( 'Background', 'unlock-elementor-widgets' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .unlock-buy-btn:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_hover_border',
				'label' => __( 'Border', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-buy-btn:hover',
			]
		);

		$this->add_control(
			'button_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-buy-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section(); // End Style Tab
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="unlock-packages-wrapper">
			<h3 class="unlock-heading elementor-inline-editing" data-elementor-setting-key="list_title" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $settings['list_title'] ); ?></h3>
			<div id="unlock-packages-list">
				<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<?php if ( ! empty( $settings['packages_list_items'] ) ) : ?>
						<?php foreach ( $settings['packages_list_items'] as $index => $item ) : 
							$repeater_setting_key = $this->get_repeater_setting_key( 'pkg_name', 'packages_list_items', $index );
							$repeater_desc_key = $this->get_repeater_setting_key( 'pkg_description', 'packages_list_items', $index );
							$repeater_price_key = $this->get_repeater_setting_key( 'pkg_price', 'packages_list_items', $index );
							$repeater_features_key = $this->get_repeater_setting_key( 'pkg_features', 'packages_list_items', $index );
						?>
							<div class="unlock-package-card elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" data-id="demo-<?php echo esc_attr( $index ); ?>">
								<?php if ( ! empty( $item['pkg_image']['url'] ) ) : ?>
									<img src="<?php echo esc_url( $item['pkg_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['pkg_name'] ); ?>" class="unlock-package-image" style="width:100%;max-width:150px;height:auto;margin-bottom:10px;">
								<?php endif; ?>
								<h4 class="unlock-package-name elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_setting_key ); ?>" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $item['pkg_name'] ); ?></h4>
								<div class="unlock-package-desc elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_desc_key ); ?>" data-elementor-inline-editing-toolbar="advanced"><?php echo nl2br( $item['pkg_description'] ); ?></div>
								<div class="unlock-package-price elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_price_key ); ?>" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $item['pkg_price'] ); ?></div>
								<?php if ( ! empty( $item['pkg_features'] ) ) : ?>
									<ul class="elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_features_key ); ?>" data-elementor-inline-editing-toolbar="advanced">
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
