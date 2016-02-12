<?php

// Start the engine
require_once( TEMPLATEPATH.'/lib/init.php' );
require_once( 'lib/init.php' );

// Calls the theme's constants & files
patricia_init();

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'wsm_add_viewport_meta_tag' );
function wsm_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Force Stupid IE to NOT use compatibility mode
add_filter( 'wp_headers', 'wsm_keep_ie_modern' );
function wsm_keep_ie_modern() {
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false ) ) {
		$headers['X-UA-Compatible'] = 'IE=edge,chrome=1';
		return $headers;
	}
}

// Load Moderinzr script for IE and Gravity Forms placeholders
add_action( 'wp_enqueue_scripts', 'wsm_load_modernizr' );
function wsm_load_modernizr() {
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'modernizr', CHILD_URL . '/lib/js/modernizr.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'modernizr' );
}

/** Create additional color style options */
add_theme_support( 'genesis-style-selector',
	array(
		'patricia-red' => 'Red',
		'patricia-green' => 'Green',
		'patricia-purple' => 'Purple',
		'patricia-orange' => 'Orange',
		'patricia-pink' => 'Pink',
	)
);

// Add new image sizes
add_image_size( 'Blog Thumbnail', 150, 182, TRUE );
add_image_size( 'Small Thumbnail', 47, 46, TRUE );

// Customize the Search Box
add_filter( 'genesis_search_button_text', 'custom_search_button_text' );
function custom_search_button_text( $text ) {
    return esc_attr( 'GO' );
}

// Modify the author box title
add_filter( 'genesis_author_box', 'wsm_author_box_pattern' );
function wsm_author_box_pattern( $pattern ) {
	$gravatar = get_avatar( get_the_author_id() , 76 );
	$description = get_the_author_meta( 'description' );
	$pattern = '<div class="author-box"><h3>By ' . get_the_author_meta( 'display_name' ) . '</h3>' . $gravatar . ' <p class="author-description">' . $description . '</p></div>';
	return $pattern;
}

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter( $post_info ) {
if ( is_single() && ! is_page() ) {
	$post_info = '[post_date before="Posted on " format="m.d.y"] [post_author_posts_link before="by " ]';
	}

else {
	$post_info = '[post_date format="m.d.y"]';
}

return $post_info;

}

//* Reposition post image (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
// Line 81 was commented out to take out the double image created on the blog page. May 24, 2015   BC 
//* add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

// Customize the post meta function
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter( $post_meta ) {
	if ( is_single()) {
    	$post_meta = '[post_categories sep=", " before="Categories: "] [post_tags sep=", " before="Tags: "]';
    	return $post_meta;
	}
}

// Add Read More button to blog page and archives
add_filter( 'excerpt_more', 'wsm_add_excerpt_more' );
add_filter( 'get_the_content_more_link', 'wsm_add_excerpt_more' );
add_filter( 'the_content_more_link', 'wsm_add_excerpt_more' );
function wsm_add_excerpt_more( $more ) {
    return '<span class="more-link"><a href="' . get_permalink() . '" rel="nofollow">Read More</a></span>';
}

/*
 * Add support for targeting individual browsers via CSS
 * See readme file located at /lib/js/css_browser_selector_readm.html
 * for a full explanation of available browser css selectors.
 */
add_action( 'get_header', 'wsm_load_scripts' );
function wsm_load_scripts() {
    wp_enqueue_script( 'browserselect', CHILD_URL.'/lib/js/css_browser_selector.js', array('jquery'), '0.4.0', TRUE );
}

// Media queries for Internet Explorer 8 and below
add_action( 'get_header', 'wsm_mediaqueries_scripts' );
function wsm_mediaqueries_scripts() {
    wp_enqueue_script( 'mediaqueries', CHILD_URL . '/lib/js/css3-mediaqueries.js', array( 'jquery' ), '0.4.0', TRUE );
}


// Structural Wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );

// Changes Default Navigation to Primary & Footer

add_theme_support ( 'genesis-menus' ,
	array (
		'primary' => __( 'Primary Navigation Menu', 'patricia' ),
		'footer' => __( 'Footer Navigation Menu', 'patricia' ),
	)
);

//* Unregister Layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );


// Setup Sidebars
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

genesis_register_sidebar( array(
	'id'			=> 'rotator',
	'name'			=> __( 'Rotator', 'patricia' ),
	'description'	=> __( 'This is the image rotator section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-top',
	'name'			=> __( 'Home Top', 'patricia' ),
	'description'	=> __( 'This is the home page top section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-cta1',
	'name'			=> __( 'Home CTA 1', 'patricia' ),
	'description'	=> __( 'This is the home page cta section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-cta2',
	'name'			=> __( 'Home CTA 2', 'patricia' ),
	'description'	=> __( 'This is the home page cta section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-cta3',
	'name'			=> __( 'Home CTA 3', 'patricia' ),
	'description'	=> __( 'This is the home page cta section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom1',
	'name'			=> __( 'Home Bottom 1', 'patricia' ),
	'description'	=> __( 'This is the home page bottom section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom2',
	'name'			=> __( 'Home Bottom 2', 'patricia' ),
	'description'	=> __( 'This is the home page bottom section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom3',
	'name'			=> __( 'Home Bottom 3', 'patricia' ),
	'description'	=> __( 'This is the home page bottom section.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'blog-sidebar',
	'name'			=> __( 'Blog Sidebar', 'patricia' ),
	'description'	=> __( 'This is the Blog Page Sidebar.', 'patricia' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'page-sidebar',
	'name'			=> __( 'Page Sidebar', 'patricia' ),
	'description'	=> __( 'This is the Page Sidebar.', 'patricia' ),
) );


// add first class to navigation
add_filter( 'wp_nav_menu', 'wsm_add_first_and_last' );
function wsm_add_first_and_last($output) {
	$output = preg_replace( '/class="menu-item/', 'class="first-menu-item menu-item ', $output, 1 );
	$output = substr_replace( $output, 'class="last-menu-item menu-item', strripos( $output, 'class="menu-item' ), strlen( 'class="menu-item' ) );
	return $output;
}

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = '<span class="arrow-sep"></span>';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = '';
	$args['labels']['author'] = '';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = '';
	$args['labels']['date'] = '';
	$args['labels']['search'] = '';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'Not found: '; // Genesis 1.5 and later
	return $args;
}

//*Adds Social Simple Icons to menu bar. August 31, 2014   BC */

genesis_register_sidebar( array(
	'id'          => 'nav-social-menu',
	'name'        => __( 'Nav Social Menu', 'your-theme-slug' ),
	'description' => __( 'This is the nav social menu section.', 'your-theme-slug' ),
) );

add_filter( 'genesis_nav_items', 'sws_social_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'sws_social_icons', 10, 2 );

function sws_social_icons($menu, $args) {
	$args = (array)$args;
	if ( 'primary' !== $args['theme_location'] )
		return $menu;
	ob_start();
	genesis_widget_area('nav-social-menu');
	$social = ob_get_clean();
	return $menu . $social;
}
function remove_wp_version() { return ''; }
add_filter('the_generator', 'remove_wp_version');


/*Aligns copy on Blog/Archive pages */

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_content', 'sk_do_post_image', 8 );
add_action( 'genesis_post_content', 'sk_do_post_image' );
/**
 * Echo the post image on archive pages.
 *
 * If this an archive page and the option is set to show thumbnail, then it gets the image size as per the theme
 * setting, wraps it in the post permalink and echoes it.
 *
 * @since 1.1.0
 *
 * @uses genesis_get_option() Get theme setting value.
 * @uses genesis_get_image()  Return an image pulled from the media library.
 * @uses genesis_parse_attr() Return contextual attributes.
 */
function sk_do_post_image() {

	if ( ! is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {
		$img = genesis_get_image( array(
			'format'  => 'html',
			'size'    => genesis_get_option( 'image_size' ),
			'context' => 'archive',
			'attr'    => genesis_parse_attr( 'entry-image' ),
		) );

		if ( ! empty( $img ) )
			printf( '<div class="archive-pages-image"><a href="%s" title="%s">%s</a></div>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}

}

/**
 * Change Image Alignment of Featured Image From Left to Center
 *
 */
function sk_change_image_alignment( $attributes ) {

	$attributes['class'] = str_replace( 'alignleft', 'aligncenter', $attributes['class'] );
		return $attributes;

}
add_filter( 'genesis_attr_entry-image', 'sk_change_image_alignment' );

/*Customer Service Notice */

function howdy_message($translated_text, $text, $domain) {
    $new_message = str_replace('Howdy', 'Call Bryan at Listen to the Wind Media at 678-520-9914 if you have a question', $text);
    return $new_message;
}
add_filter('gettext', 'howdy_message', 10, 3);


//protect emails -- source: Benjamin Bradley
function emailprotectcode( $atts , $content=null ) {
    for ($i = 0; $i < strlen($content); $i++) $encodedmail .= "&#" . ord($content[$i]) . ';';
    return '<a href="mailto:'.$encodedmail.'">'.$encodedmail.'</a>';
}
add_shortcode('emailprotect', 'emailprotectcode');


/****Custom Styles for Login Page
******************************************************************************/

/***
*Custom Login Logo
**/
function my_loginlogo() {
  echo '<style type="text/css">
    h1 a {
      background-image: url(' . get_stylesheet_directory_uri() . '/images/logo.png) !important;
    }
  </style>';
}
/**
*Hover Title for Logo
**/
add_action('login_head', 'my_loginlogo');

function my_loginURLtext() {
    return 'Enhance Worldwide';
}
add_filter('login_headertitle', 'my_loginURLtext');

/**
*Enquere Login Custom Stylesheet
**/
function my_logincustomCSSfile() {
    wp_enqueue_style('login-styles', get_stylesheet_directory_uri() . '/login_styles.css');
}
add_action('login_enqueue_scripts', 'my_logincustomCSSfile');

/**
*URL for custom logo
**/
function my_loginURL() {
    return 'http://www.enhanceworldwide.org';
}
add_filter('login_headerurl', 'my_loginURL');

