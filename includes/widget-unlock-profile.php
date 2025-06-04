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
                'label'       => __( 'Redirect If Not Logged In', 'unlock-elementor-widgets' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => __( '/login', 'unlock-elementor-widgets' ),
                'description' => __( 'Se l’utente non è autenticato, verrà reindirizzato a questo URL. Lascia vuoto per non reindirizzare.', 'unlock-elementor-widgets' ),
            ]
        );

        // Sezioni on/off
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
                <p><?php esc_html_e( 'Caricamento profilo…', 'unlock-elementor-widgets' ); ?></p>
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
