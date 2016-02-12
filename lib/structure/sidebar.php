<?php 
/**
 * Sidebar Functions
 *
 * This file controls the various sidebar displays on the site
 *
 * @category     Child Theme
 * @package      Admin
 * @author       Web Savvy Marketing
 * @copyright    Copyright (c) 2012, Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 *
 */

// Conditionally unregister sidebar
if ( ( is_admin() && wsm_is_widgets_page() ) || ( !is_admin() ) ) {
    unregister_sidebar( 'sidebar' );
}
 
function wsm_is_widgets_page() {
    return in_array( $GLOBALS['pagenow'], array( 'widgets.php', ) );
}

// Replace Sidebar With Custom Sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

add_action( 'get_header', 'wsm_child_sidebars_init', 15 );

/**
 * Remove sidebars
 */
function wsm_child_sidebars_init() {
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
	remove_action( 'genesis_sidebar', 'ss_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'ss_do_sidebar_alt' );
	add_action( 'genesis_sidebar', 'wsm_child_do_sidebar' );
}

/**
 * Checks to see if simple sidebar exists
 *
 * @return string/boolean String of sidebar key OR false if none found
 */
function wsm_child_has_ss_sidebar( $sidebar_key = '_ss_sidebar' ) {
	static $taxonomies = null;
	if ( is_singular() && $sidebar_key = genesis_get_custom_field( $sidebar_key ) ) {
		return $sidebar_key;
	}

	if ( is_category() ) {
		$term = get_term( get_query_var( 'cat' ), 'category' );
		if ( isset( $term->meta[$sidebar_key] ) ) 
			return $term->meta[$sidebar_key];
	}

	if ( is_tag() ) {
		$term = get_term( get_query_var( 'tag_id' ), 'post_tag' );
		if ( isset( $term->meta[$sidebar_key] ) ) 
			return $term->meta[$sidebar_key];
	}

	if ( is_tax() ) {
		
		if ( function_exists( 'ss_do_sidebar' ) ) {		
		
			if ( null === $taxonomies )
			$taxonomies = ss_get_taxonomies();

			foreach ( $taxonomies as $tax ) {
				if ( 'post_tag' == $tax || 'category' == $tax )
					continue;

				if ( is_tax( $tax ) ) {
					$obj = get_queried_object();
					$term = get_term( $obj->term_id, $tax );
					if ( isset( $term->meta[$sidebar_key] ) ) 
						return $term->meta[$sidebar_key];
					break;
				}
			}
		}
	}

	return false;
}


/**
 * Custom Frederik Sidebar for each sidebar
 */
function wsm_child_do_sidebar() {
	if ( $id = wsm_child_has_ss_sidebar() ) {
		if ( dynamic_sidebar( $id ) ) { /* do nothing */ }
	}
	else {
		if( is_archive() || is_single() || is_category() || is_page_template( 'page_blog.php' ) ) {
			genesis_widget_area( 'blog-sidebar');
		}
		else genesis_widget_area( 'page-sidebar');
	}
}