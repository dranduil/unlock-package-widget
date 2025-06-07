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
				'default' => __( 'Available Packages', 'unlock-elementor-widgets' ),
				'placeholder' => __( 'Enter your title here', 'unlock-elementor-widgets' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'pkg_name',
			[
				'label' => __( 'Package Name', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Demo Package Name', 'unlock-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'pkg_description',
			[
				'label' => __( 'Description', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'This is a fantastic demo package with many features.', 'unlock-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'pkg_price',
			[
				'label' => __( 'Price', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '$10', 'unlock-elementor-widgets' ),
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
				'default' => __( "Feature 1\nFeature 2", 'unlock-elementor-widgets' ),
				'placeholder' => __( "Enter one feature per line", 'unlock-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'pkg_button_text',
			[
				'label' => __( 'Button Text', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Buy Now', 'unlock-elementor-widgets' ),
				'label_block' => true,
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
						'pkg_name' => __( 'Standard Package', 'unlock-elementor-widgets' ),
						'pkg_description' => __( 'Our most popular package, offering a great balance of features and value.', 'unlock-elementor-widgets' ),
						'pkg_price' => __( '$19.99', 'unlock-elementor-widgets' ),
						'pkg_features' => __( "Feature Alpha\nFeature Beta\nFeature Gamma", 'unlock-elementor-widgets' ),
						'pkg_image' => ['url' => 'https://via.placeholder.com/150'],
                        'pkg_button_text' => __( 'Buy Now', 'unlock-elementor-widgets' ),
					],
					[
						'pkg_name' => __( 'Premium Package', 'unlock-elementor-widgets' ),
						'pkg_description' => __( 'The ultimate package for users who need all the bells and whistles.', 'unlock-elementor-widgets' ),
						'pkg_price' => __( '$39.99', 'unlock-elementor-widgets' ),
						'pkg_features' => __( "All Standard Features\nPriority Support\nExclusive Content Access", 'unlock-elementor-widgets' ),
						'pkg_image' => ['url' => 'https://via.placeholder.com/150'],
                        'pkg_button_text' => __( 'Get Premium', 'unlock-elementor-widgets' ),
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

		$this->add_responsive_control(
			'title_alignment',
			[
				'label' => __( 'Title Alignment', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .unlock-heading' => 'text-align: {{VALUE}};',
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

		$this->add_responsive_control(
			'pkg_name_alignment',
			[
				'label' => __( 'Alignment', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .unlock-package-name' => 'text-align: {{VALUE}};',
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

		$this->add_responsive_control(
			'pkg_desc_alignment',
			[
				'label' => __( 'Alignment', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .unlock-package-desc' => 'text-align: {{VALUE}};',
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

		$this->add_responsive_control(
			'pkg_price_alignment',
			[
				'label' => __( 'Alignment', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .unlock-package-price' => 'text-align: {{VALUE}};',
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

		$this->add_responsive_control(
			'pkg_features_alignment',
			[
				'label' => __( 'List Alignment', 'unlock-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .unlock-package-card ul' => 'text-align: {{VALUE}}; list-style-position: inside;', // Added list-style-position for better alignment
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
		$this->end_controls_tabs(); // End button_tabs

        $this->add_responsive_control(
            'button_alignment_list',
            [
                'label' => __( 'Button Alignment', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'unlock-elementor-widgets' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'unlock-elementor-widgets' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'unlock-elementor-widgets' ),
                        'icon' => 'eicon-h-align-right',
                    ],
					'justify' => [
						'title' => __( 'Full Width', 'unlock-elementor-widgets' ),
						'icon' => 'eicon-h-align-stretch',
					]
                ],
                'default' => 'left',
                'selectors_dictionary' => [
                    'left' => 'flex-start',
                    'center' => 'center',
                    'right' => 'flex-end',
					'justify' => 'stretch',
                ],
                'selectors' => [
                    '{{WRAPPER}} .unlock-package-card .unlock-button-wrapper' => 'align-self: {{VALUE}}; width: {{VALUE}} == "stretch" ? "100%" : "auto";',
                    '{{WRAPPER}} .unlock-package-card .unlock-buy-btn' => 'width: {{VALUE}} == "stretch" ? "100%" : "auto";',
                ],
            ]
        );

		$this->end_controls_section(); // End Style Tab
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.unlock-packages-wrapper .unlock-heading {
				/* Styles for the main title can be controlled by Elementor settings */
				margin-bottom: 1.5em;
			}
			.unlock-packages-grid {
				display: flex;
				flex-wrap: wrap;
				gap: 1.5em; /* Spacing between cards */
			}
			.unlock-package-card {
				flex: 0 1 calc(50% - 0.75em); /* Two columns with spacing */
				box-sizing: border-box;
				display: flex;
				flex-direction: column;
				background: #ffffff;
				border-radius: 12px; 
				box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
				transition: box-shadow 0.25s ease-in-out, transform 0.25s ease-in-out;
				overflow: hidden;
			}
			.unlock-package-card:hover {
				box-shadow: 0 6px 12px rgba(0,0,0,0.08), 0 4px 8px rgba(0,0,0,0.06);
				transform: translateY(-4px);
			}
			.unlock-package-image-wrapper {
				width: 100%;
				height: 160px; /* Adjusted height for image */
				overflow: hidden;
				background-color: #f8f9fa; /* Light placeholder background */
			}
			.unlock-package-image {
				width: 100%;
				height: 100%;
				object-fit: cover;
				display: block;
			}
			.unlock-package-content-wrapper {
				padding: 1em 1.25em 1.25em;
				display: flex;
				flex-direction: column;
				flex-grow: 1;
			}
			.unlock-package-name {
				font-size: 1.05em;
				font-weight: 600;
				color: #343a40;
				margin: 0 0 0.35em 0;
				line-height: 1.35;
			}
			/* Using features as meta data like in the image */
			.unlock-package-meta-data {
				font-size: 0.8em;
				color: #6c757d;
				margin-bottom: 0.75em;
				line-height: 1.4;
			}
			.unlock-package-meta-data ul {
				list-style: none;
				padding: 0;
				margin: 0;
			}
			.unlock-package-meta-data li {
				display: inline-block; /* Or block if you want them stacked */
				margin-right: 0.75em; /* Space between meta items if inline */
				/* Add icons here if desired: e.g. content: '\f073'; font-family: 'Font Awesome 5 Free'; */
			}
			.unlock-package-description {
				font-size: 0.85em;
				color: #495057;
				margin-bottom: 1em;
				line-height: 1.5;
				flex-grow: 1; /* Pushes footer down */
			}
			.unlock-package-footer {
				display: flex;
				justify-content: space-between;
				align-items: flex-end; /* Align items to the bottom of the flex container */
				margin-top: auto; 
				padding-top: 0.75em;
				/* border-top: 1px solid #dee2e6; /* Optional separator */
			}
			.unlock-package-price-wrapper {
				text-align: left;
			}
			.unlock-package-price-label {
				display: block;
				font-size: 0.75em;
				color: #6c757d;
				margin-bottom: 0.1em;
				line-height: 1;
			}
			.unlock-package-price {
				font-size: 1.6em;
				font-weight: 700;
				color: #212529;
				line-height: 1;
			}
			.unlock-buy-btn-wrapper {
				/* Wrapper for button if needed for alignment */
			}
			.unlock-buy-btn {
				padding: 0.4em 0.9em;
				font-size: 0.85em;
				/* background-color: transparent; /* Example: Ghost button */
				/* color: #007bff; */
				/* border: 1px solid #007bff; */
				background-color: #0d6efd; /* Bootstrap primary blue */
				color: white;
				border: 1px solid #0d6efd;
				border-radius: 6px;
				cursor: pointer;
				transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
				text-decoration: none;
				font-weight: 500;
				line-height: 1.5;
			}
			.unlock-buy-btn:hover {
				background-color: #0b5ed7;
				border-color: #0a58ca;
				color: white;
			}
			/* Responsive adjustments */
			@media (max-width: 767px) { /* Small devices (tablets, 768px and down) */
				.unlock-package-card {
					flex: 0 1 100%; /* Single column on smaller screens */
				}
			}
		</style>

		<div class="unlock-packages-wrapper">
			<h3 class="unlock-heading elementor-inline-editing" data-elementor-setting-key="list_title" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $settings['list_title'] ); ?></h3>
			<div id="unlock-packages-list">
				<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
					<?php if ( ! empty( $settings['packages_list_items'] ) ) : ?>
						<div class="unlock-packages-grid">
							<?php foreach ( $settings['packages_list_items'] as $index => $item ) : 
								$repeater_pkg_name_key = $this->get_repeater_setting_key( 'pkg_name', 'packages_list_items', $index );
								$repeater_pkg_desc_key = $this->get_repeater_setting_key( 'pkg_description', 'packages_list_items', $index );
								$repeater_pkg_price_key = $this->get_repeater_setting_key( 'pkg_price', 'packages_list_items', $index );
								$repeater_pkg_features_key = $this->get_repeater_setting_key( 'pkg_features', 'packages_list_items', $index );
                                $repeater_pkg_button_text_key = $this->get_repeater_setting_key( 'pkg_button_text', 'packages_list_items', $index );
							?>
								<div class="unlock-package-card elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
									<?php if ( ! empty( $item['pkg_image']['url'] ) ) : ?>
                                        <div class="unlock-package-image-wrapper">
									    <img src="<?php echo esc_url( $item['pkg_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['pkg_name'] ); ?>" class="unlock-package-image">
                                        </div>
									<?php else: ?>
										<div class="unlock-package-image-wrapper"></div> <?php /* Placeholder for no image */ ?>
									<?php endif; ?>
                                    <div class="unlock-package-content-wrapper">
    								<h4 class="unlock-package-name elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_pkg_name_key ); ?>" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $item['pkg_name'] ); ?></h4>
    								
									<?php if ( ! empty( $item['pkg_features'] ) ) : // Using features as meta data ?>
    									<div class="unlock-package-meta-data elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_pkg_features_key ); ?>" data-elementor-inline-editing-toolbar="advanced">
											<ul>
												<?php
												$features = explode( "\n", $item['pkg_features'] );
												foreach ( $features as $feature_item ) :
													if( !empty(trim($feature_item)) ) : ?>
														<li><?php echo esc_html( trim( $feature_item ) ); ?></li>
												<?php endif; endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $item['pkg_description'] ) ) : ?>
    									<div class="unlock-package-description elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_pkg_desc_key ); ?>" data-elementor-inline-editing-toolbar="advanced"><?php echo nl2br( $item['pkg_description'] ); ?></div>
									<?php endif; ?>
    								
									<div class="unlock-package-footer">
										<?php if ( ! empty( $item['pkg_price'] ) ) : ?>
											<div class="unlock-package-price-wrapper">
												<span class="unlock-package-price-label"><?php esc_html_e( 'Starting at', 'unlock-elementor-widgets' ); ?></span>
												<div class="unlock-package-price elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_pkg_price_key ); ?>" data-elementor-inline-editing-toolbar="basic"><?php echo esc_html( $item['pkg_price'] ); ?></div>
											</div>
										<?php endif; ?>

										<?php if ( ! empty( $item['pkg_button_text'] ) ) : ?>
											<div class="unlock-buy-btn-wrapper">
											    <a href="#" class="unlock-buy-btn elementor-inline-editing" data-elementor-setting-key="<?php echo esc_attr( $repeater_pkg_button_text_key ); ?>" data-elementor-inline-editing-toolbar="basic" data-id="<?php echo esc_attr( $item['_id'] ); ?>"><?php echo esc_html( $item['pkg_button_text'] ); ?></a>
											</div>
										<?php endif; ?>
									</div>
                                    </div>
								</div>
							<?php endforeach; ?> 
						</div>
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
