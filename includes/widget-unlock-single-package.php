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

		// Style Tab
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'unlock-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Widget Title Styling
		$this->add_control(
			'widget_title_style_heading',
			[
				'label' => __( 'Widget Title', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'widget_title_typography',
				'label' => __( 'Typography', 'unlock-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .unlock-heading',
			]
		);

		$this->add_control(
			'widget_title_color',
			[
				'label' => __( 'Color', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'widget_title_margin',
			[
				'label' => __( 'Margin', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Card Styling
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
				'label' => __( 'Background', 'unlock-elementor-widgets' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .unlock-package-card',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => __( 'Padding', 'unlock-elementor-widgets' ),
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
				'label' => __( 'Border', 'unlock-elementor-widgets' ),
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
				'label' => __( 'Box Shadow', 'unlock-elementor-widgets' ),
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
		$pkg_id_live = esc_attr( $settings['package_id'] ); // Used for live site
		$editor_pkg_id = $pkg_id_live ?: 'editor-preview'; // ID for editor preview

		?>
		<div class="unlock-single-package-wrapper">
			<h3 class="unlock-heading elementor-inline-editing" data-elementor-setting-key="widget_title" data-elementor-inline-editing-toolbar="basic">
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
						<h4 class="unlock-package-name elementor-inline-editing" data-elementor-setting-key="pkg_name_editor" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $settings['pkg_name_editor'] ); ?></h4>
						<div class="unlock-package-desc elementor-inline-editing" data-elementor-setting-key="pkg_description_editor" data-elementor-inline-editing-toolbar="advanced"><?php echo nl2br( $settings['pkg_description_editor'] ); ?></div>
						<div class="unlock-package-price elementor-inline-editing" data-elementor-setting-key="pkg_price_editor" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $settings['pkg_price_editor'] ); ?></div>
						<?php if ( ! empty( $settings['pkg_features_editor'] ) ) : ?>
							<ul class="elementor-inline-editing" data-elementor-setting-key="pkg_features_editor" data-elementor-inline-editing-toolbar="advanced">
								<?php
								$features = explode( "\n", $settings['pkg_features_editor'] );
								foreach ( $features as $feature ) :
									?>
									<li><?php echo esc_html( trim( $feature ) ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<button class="unlock-buy-btn" data-id="<?php echo esc_attr( $editor_pkg_id ); ?>">Buy</button>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'Caricamento dettagli…', 'unlock-elementor-widgets' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
