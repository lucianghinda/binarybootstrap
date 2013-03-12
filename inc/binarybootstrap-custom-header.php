<?php
/**
 * Implements a custom header for Binary Bootstrap.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Binary Bootstrap 1.0
 */

/**
 * Sets up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses binarybootstrap_header_style() to style front-end.
 * @uses binarybootstrap_admin_header_style() to style wp-admin form.
 * @uses binarybootstrap_admin_header_image() to add custom markup to wp-admin form.
 * @uses register_default_headers() to set up the bundled header images.
 *
 * @since Binary Bootstrap 1.0
 */
function binarybootstrap_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color' => '220e10',
		'default-image' => '%s/images/headers/circle.png',
		// Set height and width, with a maximum value for the width.
		'height' => 230,
		'width' => 1600,
		'flex-height' => true,
		// Callbacks for styling the header and the admin preview.
		'wp-head-callback' => 'binarybootstrap_header_style',
		'admin-head-callback' => 'binarybootstrap_admin_header_style',
		'admin-preview-callback' => 'binarybootstrap_admin_header_image',
	);

	add_theme_support( 'custom-header', $args );
}

add_action( 'after_setup_theme', 'binarybootstrap_custom_header_setup' );

/**
 * Styles the header text displayed on the blog.
 *
 * get_header_textcolor() options: Hide text (returns 'blank'), or any hex value.
 *
 * @since Binary Bootstrap 1.0
 */
function binarybootstrap_header_style() {
	$header_image = get_header_image();
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css">
	<?php
	if ( !empty( $header_image ) ) :
		?>
			.site-header {
				background: url(<?php header_image(); ?>) no-repeat scroll top;
				background-size: 1600px auto;
			}
		<?php
	endif;

// Has the text been hidden?
	if ( !display_header_text() ) :
		?>
			.site-title, .site-description {
				position: absolute !important;
				clip: rect(1px 1px 1px 1px); /* IE7 */
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		if ( empty( $header_image ) ) :
			?>
				.site-header hgroup {
					min-height: 0;
				}
			<?php
		endif;

// If the user has set a custom color for the text, use that.
	elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
		?>
			.site-title, .site-description {
				color: #<?php echo esc_attr( $text_color ); ?>;
			}
	<?php endif; ?>
	</style>
	<?php
}

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Binary Bootstrap 1.0
 */
function binarybootstrap_admin_header_style() {
	$header_image = get_header_image();
	?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
			-webkit-box-sizing: border-box;
			-moz-box-sizing:    border-box;
			box-sizing:         border-box;
			<?php
			if ( !empty( $header_image ) ) {
				echo 'background: url(' . esc_url( $header_image ) . ') no-repeat scroll top; background-size: 1600px auto;';
			}
			?>
			padding: 0 20px;
		}
		#headimg .hgroup {
			-webkit-box-sizing: border-box;
			-moz-box-sizing:    border-box;
			box-sizing:         border-box;
			margin: 0 auto;
			max-width: 1040px;
			<?php
			if ( !empty( $header_image ) || display_header_text() ) {
				echo 'min-height: 230px;';
			}
			?>
			width: 100%;
		}
		<?php if ( !display_header_text() ) : ?>
			#headimg h1, #headimg h2 {
				position: absolute !important;
				clip: rect(1px 1px 1px 1px); /* IE7 */
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php endif; ?>
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#headimg h1 a:hover {
		}
		#headimg h2 {
		}
		.default-header img {
			max-width: 230px;
			width: auto;
		}
	</style>
	<?php
}

/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 *
 * @since Binary Bootstrap 1.0
 */
function binarybootstrap_admin_header_image() {
	?>
	<div id="headimg" style="background: url(<?php header_image(); ?>) no-repeat scroll top; background-size: 1600px auto;">
		<?php $style = ' style="color:#' . get_header_textcolor() . ';"'; ?>
		<div class="hgroup">
			<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="#"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
		</div>
	</div>
	<?php
}
