<?php
/**
 * Add theme dashboard page
 */

function patus_theme_info() {
	$theme_data = wp_get_theme();
	add_theme_page( sprintf( esc_html__( '%s Theme Dashboard', 'patus' ), $theme_data->Name ), sprintf( esc_html__('%s Dashboard', 'patus'), $theme_data->Name), 'edit_theme_options', strtolower( $theme_data->Name ), 'patus_theme_info_page');
}
add_action('admin_menu', 'patus_theme_info');


function patus_theme_info_page() {

	$theme_data = wp_get_theme();
	// Check for current viewing tab
	$tab = null;
	if ( isset( $_GET['tab'] ) ) {
		$tab = $_GET['tab'];
	} else {
		$tab = null;
	}
	?>

	<div class="wrap about-wrap theme_info_wrapper">
		<h1><?php printf(esc_html__('Welcome to %1s - Version %2s', 'patus'), $theme_data->Name, $theme_data->Version ); ?></h1>
		<div class="about-text">Patus is a personal blogging theme for WordPress and an effortlessly tool for publishers of all kind, cherished for its flexibility, clean layouts and speed.</div>
		<a target="_blank" href="<?php echo esc_url('https://www.famethemes.com/?utm_source=theme_info&utm_medium=badge_link&utm_campaign=patus'); ?>" class="famethemes-badge wp-badge"><span>FameThemes</span></a>
		<h2 class="nav-tab-wrapper">
            <a href="?page=patus" class="nav-tab nav-tab-active"><?php echo $theme_data->Name; ?></a>
            <a href="<?php echo esc_url( add_query_arg( array( 'page'=>'patus', 'tab' => 'demo-data-importer' ), admin_url( 'themes.php' ) ) ); ?>" class="nav-tab<?php echo $tab == 'demo-data-importer' ? ' nav-tab-active' : null; ?>"><?php esc_html_e( 'One Click Demo Import', 'patus' ); ?></span></a>
        </h2>

		<?php if ( is_null($tab) ) { ?>
		<div class="theme_info">
			<div class="theme_info_column clearfix">
				<div class="theme_info_left">
					<div class="theme_link">
						<h3>Theme Customizer</h3>
						<p class="about"><?php printf(esc_html__('%s supports the Theme Customizer for all theme settings. Click "Customize" to start customize your site.', 'patus'), $theme_data->Name); ?></p>
						<p>
							<a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary"><?php esc_html_e('Start Customize', 'patus'); ?></a>
						</p>
					</div>
					<div class="theme_link">
						<h3>Theme Documentation</h3>
						<p class="about"><?php printf(esc_html__('Need any help to setup and configure %s? Please have a look at our documentations instructions.', 'patus'), $theme_data->Name); ?></p>
						<p>
							<a href="<?php echo esc_url( esc_html__( 'http://docs.famethemes.com/category/115-patus', 'patus' ) ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e('Online Documentation', 'patus'); ?></a>
						</p>
					</div>
					<div class="theme_link">
						<h3>Having Trouble, Need Support?</h3>
						<p class="about"><?php printf(esc_html__('Support for %s WordPress theme is conducted through the WordPress free theme support forum.', 'patus'), $theme_data->Name); ?></p>
						<p>
							<a href="<?php echo esc_url( esc_html__( 'https://wordpress.org/support/theme/patus', 'patus' ) ); ?>" target="_blank" class="button button-secondary"><?php echo sprintf( esc_html('Go To %s Support Forum', 'patus'), $theme_data->Name); ?></a>
						</p>
					</div>
				</div>

				<div class="theme_info_right">

					<img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="Theme Screenshot" />

				</div>
			</div>
		</div>
        <?php } ?>


		<?php if ( $tab == 'demo-data-importer' ) { ?>
            <div class="demo-import-tab-content theme_info">
				<?php if ( has_action( 'patus_demo_import_content_tab' ) ) {
					do_action( 'patus_demo_import_content_tab' );
				} else { ?>
                    <div id="plugin-filter" class="demo-import-boxed">
						<?php
						$plugin_name = 'famethemes-demo-importer';
						$status = is_dir( WP_PLUGIN_DIR . '/' . $plugin_name );
						$button_class = 'install-now button';
						$button_txt = esc_html__( 'Install Now', 'patus' );
						if ( ! $status ) {
							$install_url = wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'install-plugin',
										'plugin' => $plugin_name
									),
									network_admin_url( 'update.php' )
								),
								'install-plugin_'.$plugin_name
							);
						} else {
							$install_url = add_query_arg(array(
								'action' => 'activate',
								'plugin' => rawurlencode( $plugin_name . '/' . $plugin_name . '.php' ),
								'plugin_status' => 'all',
								'paged' => '1',
								'_wpnonce' => wp_create_nonce('activate-plugin_' . $plugin_name . '/' . $plugin_name . '.php'),
							), network_admin_url('plugins.php'));
							$button_class = 'activate-now button-primary';
							$button_txt = esc_html__( 'Active Now', 'patus' );
						}
						$detail_link = add_query_arg(
							array(
								'tab' => 'plugin-information',
								'plugin' => $plugin_name,
								'TB_iframe' => 'true',
								'width' => '772',
								'height' => '349',
							),
							network_admin_url( 'plugin-install.php' )
						);
						echo '<p>';
						printf( esc_html__(
							'Hey, you will need to install and activate the %1$s plugin first.', 'patus' ),
							'<a class="thickbox open-plugin-details-modal" href="'.esc_url( $detail_link ).'">'.esc_html__( 'FameThemes Demo Importer', 'patus' ).'</a>'
						);
						echo '</p>';
						echo '<p class="plugin-card-'.esc_attr( $plugin_name ).'"><a href="'.esc_url( $install_url ).'" data-slug="'.esc_attr( $plugin_name ).'" class="'.esc_attr( $button_class ).'">'.$button_txt.'</a></p>';
						?>
                    </div>
				<?php } ?>
            </div>
		<?php } ?>
        
	</div> <!-- END .theme_info -->

<?php
}
?>
