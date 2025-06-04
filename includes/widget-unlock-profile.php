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

		// 1) Redirect URL se non loggato
		$this->add_control(
			'redirect_url',
			[
				'label'       => __( 'Redirect If Not Logged In', 'unlock-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '/login', 'unlock-elementor-widgets' ),
				'description' => __( 'Se l’utente non è autenticato, verrà reindirizzato a questo URL. Lascia vuoto per non reindirizzare.', 'unlock-elementor-widgets' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$redirect_url = ( ! empty( $settings['redirect_url']['url'] ) )
			? esc_url( $settings['redirect_url']['url'] )
			: '';
		?>
		<div class="unlock-profile-wrapper"
		     <?php if ( $redirect_url ) : ?>data-redirect-url="<?php echo $redirect_url; ?>"<?php endif; ?>>
			<div id="unlock-profile-content">
				<p><?php esc_html_e( 'Caricamento profilo…', 'unlock-elementor-widgets' ); ?></p>
			</div>
		</div>
		<?php
	}
}
