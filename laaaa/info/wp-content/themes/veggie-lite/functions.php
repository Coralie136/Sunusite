<?php
/**
 * veggie functions and definitions
 *
 * @package Veggie Lite
 */

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! isset( $content_width ) )
	$content_width = 740; /* pixels */

/**
 * Adjusts content_width value for full-width page and grid page.
 */
if ( ! function_exists( 'veggie_content_width' ) ) :

function veggie_content_width() {
	global $content_width;
	if ( is_page_template( 'fullwidth-page.php' ))
		$content_width = 1088;
}
add_action( 'template_redirect', 'veggie_content_width' );

endif; // if ! function_exists( 'veggie_content_width' )

if ( ! function_exists( 'veggie_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function veggie_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on veggie, use a find and replace
	 * to change 'veggie' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'veggie', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Activate support for featured images
	add_theme_support( 'post-thumbnails' );

	// Set the post thumbnail default size to suit the theme layout
	add_image_size( 'default-thumb', 740, 9999 );

	add_filter( 'excerpt_more', 'veggie_continue_reading_link' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/* Add support for editor styles */
	add_editor_style( array( 'editor-style.css', veggie_fonts_url() ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'veggie-lite' ),
		'social'  => esc_html__( 'Social Menu', 'veggie-lite' ),
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'veggie_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );
}
endif; // veggie_setup
add_action( 'after_setup_theme', 'veggie_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function veggie_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'veggie-lite' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Widgetized Block', 'veggie-lite' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets 1', 'veggie-lite' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets 2', 'veggie-lite' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets 3', 'veggie-lite' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'veggie_widgets_init' );

if ( ! function_exists( 'veggie_fonts_url' ) ) :
/**
 * Define Google Fonts
 */
function veggie_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Roboto, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$josefin = esc_html_x( 'on', 'Josefin Sans: on or off', 'veggie-lite' );

	/* Translators: If there are characters in your language that are not
	* supported by Pacifico, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$open = esc_html_x( 'on', 'Open Sans font: on or off', 'veggie-lite' );

	if ( 'off' !== $josefin || 'off' !== $open ) {
		$font_families = array();

		if ( 'off' !== $josefin ) {
			$font_families[] = 'Josefin Sans:400,100,100italic,300,300italic,400italic,600,600italic,700,700italic';
		}

		if ( 'off' !== $open ) {
			$font_families[] = 'Open Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 */
function veggie_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'veggie-fonts', veggie_fonts_url(), array(), null );

	wp_enqueue_style( 'veggie-style', get_stylesheet_uri() );

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	wp_enqueue_style( 'veggie-veggie', veggie_fonts_url(), array(), null );

	wp_enqueue_script( 'veggie-search', get_template_directory_uri() . '/js/search.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'veggie-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'veggie-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'veggie_scripts' );

if (!function_exists('veggie_lite_admin_scripts')) {
	function veggie_lite_admin_scripts($hook) {
		if ('appearance_page_blog' === $hook) {
			wp_enqueue_style('veggie-lite-admin', get_template_directory_uri() . '/admin/admin.css');
		}
	}
}
add_action('admin_enqueue_scripts', 'veggie_lite_admin_scripts');


/*
 * Filters the Categories archive widget to add a span around the post count
 */

function veggie_cat_count_span( $links ) {
	$links = str_replace( '</a> (', '</a><span class="post-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return $links;
}
add_filter( 'wp_list_categories', 'veggie_cat_count_span' );

/*
 * Add a span around the post count in the Archives widget
 */

function veggie_archive_count_span( $links ) {
  $links = str_replace( '</a>&nbsp;(', '</a><span class="post-count">(', $links );
  $links = str_replace( ')', ')</span>', $links );
  return $links;
}
add_filter( 'get_archives_link', 'veggie_archive_count_span' );

if ( ! function_exists( 'veggie_continue_reading_link' ) ) :
/**
 * Returns an ellipsis and "Continue reading" plus off-screen title link for excerpts
 */
function veggie_continue_reading_link() {
	return '&hellip; <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . sprintf( wp_kses_post( esc_html__( 'Continue reading &rarr;', 'veggie-lite' ) ), esc_attr( strip_tags( get_the_title() ) ) ) . '</a>';
}
endif; // veggie_continue_reading_link

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function veggie_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= veggie_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'veggie_custom_excerpt_more' );

/*
 * Custom comments display to move Reply link,
 * used in comments.php
 */
function veggie_comments( $comment, $args, $depth ) {
?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-metadata">
						<span class="comment-author vcard">
							<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

							<?php printf( '<b class="fn">%s</b>', get_comment_author_link() ); ?>
						</span>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( '<span class="comment-date">%1$s</span><span class="comment-time screen-reader-text">%2$s</span>', get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>'
						) ) );
						?>
						<?php edit_comment_link( esc_html__( 'Edit', 'veggie-lite' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'veggie-lite' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
<?php
}

/***** Include Admin *****/

if (is_admin()) {
	require_once('admin/admin.php');
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Styles.
 *
 * @since Veggie 1.0
 */
require( get_template_directory() . '/inc/veggie_customizer_style.php' );