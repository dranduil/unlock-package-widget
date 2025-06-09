<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Unlock_Widget_Profile extends \Elementor\Widget_Base {

    public function get_name() {
        return 'unlock_profile';
    }

    public function get_title() {
        return __( 'Unlock Profile', 'unlock-elementor-widgets' );
    }

    public function get_icon() {
        return 'eicon-user-circle';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_script_depends() {
        return [ 'unlock-widgets-js' ];
    }

    protected function _register_controls() {

        // ───── CONTENT TAB ─────
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'unlock-elementor-widgets' ),
            ]
        );

        // Redirect se non loggato
        $this->add_control(
            'redirect_url',
            [
                'label'       => __( 'Redirect URL if not logged in', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'url',
                'placeholder' => __( 'e.g., /login', 'unlock-elementor-widgets' ),
                'default'     => '/',
                'description' => __( 'Enter the URL (e.g., /login or full https://...) to redirect to if the user is not logged in. Defaults to homepage (/).', 'unlock-elementor-widgets' ),
            ]
        );

        // Section: Visibility Settings
        $sections = [
            'avatar'       => __( 'Avatar', 'unlock-elementor-widgets' ),
            'fullname'     => __( 'Full Name', 'unlock-elementor-widgets' ),
            'email'        => __( 'Email', 'unlock-elementor-widgets' ),
            'phone'        => __( 'Phone', 'unlock-elementor-widgets' ),
            'jobtitle'     => __( 'Job Title', 'unlock-elementor-widgets' ),
            'location'     => __( 'Location', 'unlock-elementor-widgets' ),
            'company'      => __( 'Company', 'unlock-elementor-widgets' ),
            'joindate'     => __( 'Join Date', 'unlock-elementor-widgets' ),
            'roles'        => __( 'Roles', 'unlock-elementor-widgets' ),
            'biography'    => __( 'Biography', 'unlock-elementor-widgets' ),
            'link'         => __( 'Link', 'unlock-elementor-widgets' ),
            'subscription' => __( 'Subscription', 'unlock-elementor-widgets' ),
            'payment'      => __( 'Payment Methods', 'unlock-elementor-widgets' ),
            'nationality'  => __( 'Nationality', 'unlock-elementor-widgets' ),
            'gender'       => __( 'Gender', 'unlock-elementor-widgets' ),
            'credits'      => __( 'Credits', 'unlock-elementor-widgets' ),
        ];

        foreach ( $sections as $key => $label ) {
            $this->add_control(
                "show_{$key}",
                [
                    'label'        => sprintf( __( 'Show %s', 'unlock-elementor-widgets' ), $label ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Yes', 'unlock-elementor-widgets' ),
                    'label_off'    => __( 'No', 'unlock-elementor-widgets' ),
                    'return_value' => 'yes',
                    'default'      => ( $key === 'fullname' ) ? 'yes' : 'no',
                ]
            );
        }

        // Etichette personalizzate
        $this->add_control(
            'label_fullname',
            [
                'label'       => __( 'Full Name Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Name', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Name', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_fullname' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_email',
            [
                'label'       => __( 'Email Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Email', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Email', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_email' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_phone',
            [
                'label'       => __( 'Phone Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Phone', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Phone', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_phone' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_jobtitle',
            [
                'label'       => __( 'Job Title Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Job Title', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Job Title', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_jobtitle' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_location',
            [
                'label'       => __( 'Location Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Location', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Location', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_location' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_company',
            [
                'label'       => __( 'Company Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Company', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Company', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_company' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_joindate',
            [
                'label'       => __( 'Join Date Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Joined On', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Joined On', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_joindate' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_roles',
            [
                'label'       => __( 'Roles Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Roles', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Roles', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_roles' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_biography',
            [
                'label'       => __( 'Biography Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Biography', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Biography', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_biography' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_link',
            [
                'label'       => __( 'Link Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Website', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Website', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_link' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_subscription',
            [
                'label'       => __( 'Subscription Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Subscription', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Subscription', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_subscription' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_payment',
            [
                'label'       => __( 'Payment Methods Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Payment Methods', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Payment Methods', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_payment' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_nationality',
            [
                'label'       => __( 'Nationality Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Nationality', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Nationality', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_nationality' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_gender',
            [
                'label'       => __( 'Gender Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Gender', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Gender', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_gender' => 'yes' ],
            ]
        );

        $this->add_control(
            'label_credits',
            [
                'label'       => __( 'Credits Label', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Credits', 'unlock-elementor-widgets' ),
                'placeholder' => __( 'Es. Credits', 'unlock-elementor-widgets' ),
                'condition'   => [ 'show_credits' => 'yes' ],
            ]
        );

        // Avatar size
        $this->add_responsive_control(
            'avatar_size',
            [
                'label'      => __( 'Avatar Size (px)', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'show_avatar' => 'yes' ],
                'default'   => [ 'size' => 80 ],
            ]
        );

        $this->end_controls_section();


        // ───── STYLE TAB: Section Headings ─────
        $this->start_controls_section(
            'section_style_headings',
            [
                'label' => __( 'Section Headings', 'unlock-elementor-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Color for all headings (e.g. "Informazioni Utente", "Biography", ecc.)
        $this->add_control(
            'section_heading_color',
            [
                'label'     => __( 'Heading Color', 'unlock-elementor-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-section h4' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography for headings
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'section_heading_typography',
                'label'    => __( 'Heading Typography', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-section h4',
            ]
        );

        $this->end_controls_section();

        // ───── STYLE TAB: Content Text ─────
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __( 'Content Text', 'unlock-elementor-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Color for all content text
        $this->add_control(
            'content_text_color',
            [
                'label'     => __( 'Content Text Color', 'unlock-elementor-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-content, 
                     {{WRAPPER}} .unlock-profile-content ul,
                     {{WRAPPER}} .unlock-profile-content li,
                     {{WRAPPER}} .unlock-profile-content p,
                     {{WRAPPER}} .unlock-profile-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography for content
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => __( 'Content Typography', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-content, {{WRAPPER}} .unlock-profile-content p, {{WRAPPER}} .unlock-profile-content ul li, {{WRAPPER}} .unlock-profile-content a',
            ]
        );

        $this->end_controls_section();

        // ───── STYLE TAB: Spacing ─────
        $this->start_controls_section(
            'section_style_spacing',
            [
                'label' => __( 'Spacing', 'unlock-elementor-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Spazio tra sezioni
        $this->add_responsive_control(
            'section_margin_bottom',
            [
                'label'      => __( 'Section Spacing (Margin Bottom)', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'default'    => [ 'size' => 20 ],
            ]
        );

        $this->end_controls_section();

        // ───── STYLE TAB: Avatar ─────
        $this->start_controls_section(
            'section_style_avatar',
            [
                'label' => __( 'Avatar', 'unlock-elementor-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_avatar' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'avatar_size_slider', // Renamed from avatar_size to avoid conflict if old one is still cached by Elementor
            [
                'label'      => __( 'Avatar Size', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 30,
                        'max' => 300,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'avatar_border_radius',
            [
                'label'      => __( 'Avatar Border Radius', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'unit' => '%',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'avatar_border',
                'label' => __( 'Avatar Border', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-avatar',
            ]
        );

        $this->add_responsive_control(
            'avatar_margin',
            [
                'label'      => __( 'Avatar Margin', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ───── STYLE TAB: Profile Fields ─────
        $this->start_controls_section(
            'section_style_profile_fields',
            [
                'label' => __( 'Profile Fields', 'unlock-elementor-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // --- Full Name Styling ---
        $this->add_control(
            'heading_fullname_style',
            [
                'label' => __( 'Full Name', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'   => [ 'show_fullname' => 'yes' ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'fullname_typography',
                'label' => __( 'Full Name Typography', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-fullname, {{WRAPPER}} .unlock-profile-name h2', // Target both potential classes
                'condition'   => [ 'show_fullname' => 'yes' ],
            ]
        );

        $this->add_control(
            'fullname_color',
            [
                'label' => __( 'Full Name Color', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-fullname, {{WRAPPER}} .unlock-profile-name h2' => 'color: {{VALUE}};'
                ],
                'condition'   => [ 'show_fullname' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'fullname_margin',
            [
                'label'      => __( 'Full Name Margin', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-fullname, {{WRAPPER}} .unlock-profile-name h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'   => [ 'show_fullname' => 'yes' ],
            ]
        );

        // --- Email Styling ---
        $this->add_control(
            'heading_email_style',
            [
                'label' => __( 'Email', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'   => [ 'show_email' => 'yes' ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'email_typography',
                'label' => __( 'Email Typography', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-email-label, {{WRAPPER}} .unlock-profile-email-value',
                'condition'   => [ 'show_email' => 'yes' ],
            ]
        );
        $this->add_control(
            'email_label_color',
            [
                'label' => __( 'Email Label Color', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-email-label' => 'color: {{VALUE}};'
                ],
                'condition'   => [ 'show_email' => 'yes' ],
            ]
        );
        $this->add_control(
            'email_value_color',
            [
                'label' => __( 'Email Value Color', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-email-value' => 'color: {{VALUE}};'
                ],
                'condition'   => [ 'show_email' => 'yes' ],
            ]
        );
        $this->add_responsive_control(
            'email_spacing',
            [
                'label' => __( 'Email Field Spacing (Bottom)', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => ['min' => 0, 'max' => 50],
                    'em' => ['min' => 0, 'max' => 5, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-field-email' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [ 'show_email' => 'yes' ],
            ]
        );

        // --- Generic Field Label Styling ---
        $this->add_control(
            'heading_field_label_style',
            [
                'label' => __( 'Field Labels (Generic)', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_label_typography',
                'label' => __( 'Typography', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-field-label, {{WRAPPER}} .unlock-profile-section ul li strong',
            ]
        );
        $this->add_control(
            'field_label_color',
            [
                'label' => __( 'Color', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-field-label, {{WRAPPER}} .unlock-profile-section ul li strong' => 'color: {{VALUE}};'
                ],
            ]
        );

        // --- Generic Field Value Styling ---
        $this->add_control(
            'heading_field_value_style',
            [
                'label' => __( 'Field Values (Generic)', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_value_typography',
                'label' => __( 'Typography', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-field-value, {{WRAPPER}} .unlock-profile-section ul li',
            ]
        );
        $this->add_control(
            'field_value_color',
            [
                'label' => __( 'Color', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-field-value, {{WRAPPER}} .unlock-profile-section ul li' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'field_item_spacing',
            [
                'label' => __( 'Field Item Spacing (Bottom)', 'unlock-elementor-widgets' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => ['min' => 0, 'max' => 50],
                    'em' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .unlock-profile-section ul li, {{WRAPPER}} .unlock-profile-field' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        // ───── STYLE TAB: Wrapper Container ─────
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => __( 'Wrapper Container', 'unlock-elementor-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'wrapper_background',
                'label' => __( 'Background', 'unlock-elementor-widgets' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .unlock-profile-wrapper',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __( 'Padding', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_border',
                'label' => __( 'Border', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-wrapper',
            ]
        );

        $this->add_responsive_control(
            'wrapper_border_radius',
            [
                'label'      => __( 'Border Radius', 'unlock-elementor-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .unlock-profile-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_box_shadow',
                'label' => __( 'Box Shadow', 'unlock-elementor-widgets' ),
                'selector' => '{{WRAPPER}} .unlock-profile-wrapper',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $elementor_settings = $this->get_settings_for_display();
        $redirect_url = ! empty( $elementor_settings['redirect_url']['url'] ) ? esc_url( $elementor_settings['redirect_url']['url'] ) : '';

        $js_settings = [];

        // Define mappings from Elementor control IDs to JavaScript setting keys
        $visibility_map = [
            'show_avatar'       => 'show_avatar',
            'show_fullname'     => 'show_fullname',
            'show_email'        => 'show_email',
            'show_phone'        => 'show_phone',
            'show_jobtitle'     => 'show_job_title',      // Elementor 'show_jobtitle' -> JS 'show_job_title'
            'show_location'     => 'show_location',
            'show_company'      => 'show_company',
            'show_joindate'     => 'show_join_date',      // Elementor 'show_joindate' -> JS 'show_join_date'
            'show_roles'        => 'show_roles',
            'show_biography'    => 'show_biography',
            'show_link'         => 'show_link',
            'show_subscription' => 'show_subscription',
            'show_payment'      => 'show_payment_methods',// Elementor 'show_payment' -> JS 'show_payment_methods'
            'show_nationality'  => 'show_nationality',
            'show_gender'       => 'show_gender',
            'show_credits'      => 'show_credits',
        ];

        foreach ($visibility_map as $elementor_key => $js_key) {
            $js_settings[$js_key] = !empty($elementor_settings[$elementor_key]) && $elementor_settings[$elementor_key] === 'yes' ? 'yes' : 'no';
        }

        $label_map = [
            'label_fullname'     => 'label_fullname', // Though not directly used by createField, good for consistency
            'label_email'        => 'label_email',
            'label_phone'        => 'label_phone',
            'label_jobtitle'     => 'label_job_title',
            'label_location'     => 'label_location',
            'label_company'      => 'label_company',
            'label_joindate'     => 'label_join_date',
            'label_roles'        => 'label_roles',
            'label_biography'    => 'label_biography',
            'label_link'         => 'label_link',
            'label_nationality'  => 'label_nationality',
            // 'label_phone_code' is not a direct Elementor control, but JS might use it if Nationality is shown.
            // It's derived data, so JS handles it based on nationality data from API.
            'label_gender'       => 'label_gender',
            'label_credits'      => 'label_credits',
            // Section Headings (from Elementor controls)
            'section_user_info_heading_text' => 'label_user_info_heading',       // Assuming Elementor control ID is 'section_user_info_heading_text'
            'section_bio_link_heading_text' => 'label_bio_link_heading',         // Assuming Elementor control ID is 'section_bio_link_heading_text'
            'section_subscription_heading_text' => 'label_subscription_heading', // Assuming Elementor control ID is 'section_subscription_heading_text'
            'section_payment_methods_heading_text' => 'label_payment_methods_heading',// Assuming Elementor control ID is 'section_payment_methods_heading_text'
            'section_nat_gender_heading_text' => 'label_nat_gender_heading',    // Assuming Elementor control ID is 'section_nat_gender_heading_text'
            'section_credits_heading_text' => 'label_credits_heading',       // Assuming Elementor control ID is 'section_credits_heading_text'
            // Subscription specific labels
            'label_subscription_plan' => 'label_subscription_plan',
            'label_subscription_renewal' => 'label_subscription_renewal',
            'label_subscription_features' => 'label_subscription_features',
            'label_no_subscription' => 'label_no_subscription',
            // Payment specific labels
            'label_no_payment_methods' => 'label_no_payment_methods',
        ];

        // Populate labels, falling back to defaults if not set in Elementor
        // Note: Elementor controls have default values, so they should usually be set.
        foreach ($label_map as $elementor_key => $js_key) {
            if (isset($elementor_settings[$elementor_key]) && !empty($elementor_settings[$elementor_key])) {
                $js_settings[$js_key] = $elementor_settings[$elementor_key];
            } else {
                // Fallback or default logic if needed, though Elementor usually provides defaults.
                // For example, for 'label_user_info_heading', if $elementor_settings['section_user_info_heading_text'] is empty,
                // you might set a hardcoded default: $js_settings['label_user_info_heading'] = 'User Information';
            }
        }

        // Avatar size (JS currently uses CSS for this, but can be passed if needed for JS logic)
        if ($js_settings['show_avatar'] === 'yes' && isset($elementor_settings['avatar_size']['size'])) {
            $js_settings['avatar_size'] = intval($elementor_settings['avatar_size']['size']);
        }

        ?>
        <div class="unlock-profile-widget" data-redirect-url="<?php echo esc_attr( $redirect_url ); ?>">
            <div id="unlock-profile-content">
                <!-- Content will be dynamically loaded by JavaScript -->
                <!-- Basic structure for the card layout -->
                <div class="unlock-profile-card-header">
                    <!-- Avatar and user info will be injected here by JS -->
                </div>
                <div class="unlock-profile-dashboard-body">
                    <!-- Sections will be injected here by JS -->
                </div>
                 <p style="text-align:center; padding: 20px; color: #777;">Loading profile details...</p>
            </div>
            <div class="unlock-profile-settings" style="display:none;" 
                 data-settings='<?php echo esc_attr( wp_json_encode( $js_settings ) ); ?>'>
            </div>
        </div>
        <?php
    }
}
