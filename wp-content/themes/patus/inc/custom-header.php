<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Patus
 */
/**
 * Set up the WordPress core custom header feature.
 *
 * @uses patus_header_style()
 * @uses patus_admin_header_style()
 * @uses patus_admin_header_image()
 */
function patus_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'patus_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 978,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'patus_header_style',
		'admin-head-callback'    => 'patus_admin_header_style',
		'admin-preview-callback' => 'patus_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'patus_custom_header_setup' );
if ( ! function_exists( 'patus_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see patus_custom_header_setup().
 */
function patus_header_style() {
	$header_text_color = get_header_textcolor(); 
	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( get_theme_support( 'custom-header', 'default-text-color' ) == $header_text_color ) {
		return;
	}
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
        .site-branding .site-title a,
		.site-description {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // patus_header_style
if ( ! function_exists( 'patus_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see patus_custom_header_setup().
 */
function patus_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
			margin: 0px 0px 10px 0px;
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#desc {
			text-transform: uppercase;
			letter-spacing: 1px;
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // patus_admin_header_style


if ( ! function_exists( 'patus_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see patus_custom_header_setup().
 */
function patus_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // patus_admin_header_image
