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
        $settings     = $this->get_settings_for_display();
        $redirect_url = ( ! empty( $settings['redirect_url']['url'] ) )
            ? esc_url( $settings['redirect_url']['url'] )
            : '';

        // Raccogliamo quali sezioni mostrare
        $show = [
            'avatar'       => ( $settings['show_avatar'] === 'yes' ),
            'fullname'     => ( $settings['show_fullname'] === 'yes' ),
            'email'        => ( $settings['show_email'] === 'yes' ),
            'phone'        => ( $settings['show_phone'] === 'yes' ),
            'jobtitle'     => ( $settings['show_jobtitle'] === 'yes' ),
            'location'     => ( $settings['show_location'] === 'yes' ),
            'company'      => ( $settings['show_company'] === 'yes' ),
            'joindate'     => ( $settings['show_joindate'] === 'yes' ),
            'roles'        => ( $settings['show_roles'] === 'yes' ),
            'biography'    => ( $settings['show_biography'] === 'yes' ),
            'link'         => ( $settings['show_link'] === 'yes' ),
            'subscription' => ( $settings['show_subscription'] === 'yes' ),
            'payment'      => ( $settings['show_payment'] === 'yes' ),
            'nationality'  => ( $settings['show_nationality'] === 'yes' ),
            'gender'       => ( $settings['show_gender'] === 'yes' ),
            'credits'      => ( $settings['show_credits'] === 'yes' ),
        ];
        ?>
        <div class="unlock-profile-wrapper"
             <?php if ( $redirect_url ) : ?>data-redirect-url="<?php echo $redirect_url; ?>"<?php endif; ?>>
            <div id="unlock-profile-content">
                <?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
                    <?php
                    // Demo data for Elementor editor
                    $demo_data = [
                        'avatar'       => 'https://via.placeholder.com/150',
                        'fullname'     => 'John Doe',
                        'email'        => 'john.doe@example.com',
                        'phone'        => '+1234567890',
                        'jobtitle'     => 'Web Developer',
                        'location'     => 'New York, USA',
                        'company'      => 'Unlock Inc.',
                        'joindate'     => '2023-01-15',
                        'roles'        => 'Subscriber, Editor',
                        'biography'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'link'         => 'https://example.com',
                        'subscription' => 'Premium Plan (Renews on 2024-12-31)',
                        'payment'      => 'Visa **** **** **** 1234',
                        'nationality'  => 'American',
                        'gender'       => 'Male',
                        'credits'      => '100 Credits',
                    ];
                    ?>
                    <div class="unlock-profile-sections">
                        <?php foreach ( $show as $key => $is_visible ) : ?>
                            <?php if ( $is_visible && isset( $demo_data[ $key ] ) ) : ?>
                                <div class="unlock-profile-section unlock-profile-section-<?php echo esc_attr( $key ); ?>">
                                    <?php if ( $key === 'avatar' && $settings['show_avatar'] === 'yes' ) : ?>
                                        <img src="<?php echo esc_url( $demo_data['avatar'] ); ?>" alt="<?php esc_attr_e( 'User Avatar', 'unlock-elementor-widgets' ); ?>" class="unlock-profile-avatar" style="width: <?php echo intval( $settings['avatar_size']['size'] ); ?>px; height: auto; border-radius: <?php echo esc_attr( $settings['avatar_border_radius']['top'] . $settings['avatar_border_radius']['unit'] ); ?>;">
                                    <?php else : ?>
                                        <h4 class="unlock-profile-field-label"><?php echo esc_html( $settings[ "label_{$key}" ] ); ?></h4>
                                        <p class="unlock-profile-field-value"><?php echo esc_html( $demo_data[ $key ] ); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p><?php esc_html_e( 'Loading profile…', 'unlock-elementor-widgets' ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Passiamo in data-* quali sezioni mostrare e quali etichette usare -->
            <div class="unlock-profile-settings" style="display:none;"
                 <?php foreach ( $show as $key => $val ) : ?>
                     data-show-<?php echo esc_attr( $key ); ?>="<?php echo $val ? '1' : '0'; ?>"
                 <?php endforeach; ?>
                 <?php if ( $settings['show_avatar'] === 'yes' ) : ?>
                     data-avatar-size="<?php echo intval( $settings['avatar_size']['size'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_fullname'] === 'yes' ) : ?>
                     data-label-fullname="<?php echo esc_attr( $settings['label_fullname'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_email'] === 'yes' ) : ?>
                     data-label-email="<?php echo esc_attr( $settings['label_email'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_phone'] === 'yes' ) : ?>
                     data-label-phone="<?php echo esc_attr( $settings['label_phone'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_jobtitle'] === 'yes' ) : ?>
                     data-label-jobtitle="<?php echo esc_attr( $settings['label_jobtitle'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_location'] === 'yes' ) : ?>
                     data-label-location="<?php echo esc_attr( $settings['label_location'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_company'] === 'yes' ) : ?>
                     data-label-company="<?php echo esc_attr( $settings['label_company'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_joindate'] === 'yes' ) : ?>
                     data-label-joindate="<?php echo esc_attr( $settings['label_joindate'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_roles'] === 'yes' ) : ?>
                     data-label-roles="<?php echo esc_attr( $settings['label_roles'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_biography'] === 'yes' ) : ?>
                     data-label-biography="<?php echo esc_attr( $settings['label_biography'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_link'] === 'yes' ) : ?>
                     data-label-link="<?php echo esc_attr( $settings['label_link'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_subscription'] === 'yes' ) : ?>
                     data-label-subscription="<?php echo esc_attr( $settings['label_subscription'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_payment'] === 'yes' ) : ?>
                     data-label-payment="<?php echo esc_attr( $settings['label_payment'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_nationality'] === 'yes' ) : ?>
                     data-label-nationality="<?php echo esc_attr( $settings['label_nationality'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_gender'] === 'yes' ) : ?>
                     data-label-gender="<?php echo esc_attr( $settings['label_gender'] ); ?>"
                 <?php endif; ?>
                 <?php if ( $settings['show_credits'] === 'yes' ) : ?>
                     data-label-credits="<?php echo esc_attr( $settings['label_credits'] ); ?>"
                 <?php endif; ?>
            ></div>
        </div>
        <?php
    }
}
