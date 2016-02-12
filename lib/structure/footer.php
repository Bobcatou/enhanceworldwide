<?php 

/**
 * Footer Functions
 *
 * This file controls the footer on the site. The standard Genesis footer
 * has been replaced with one that has menu links on the right side and
 * copyright and credits on the left side.
 *
 * @category     ChildTheme
 * @package      Admin
 * @author       Web Savvy Marketing
 * @copyright    Copyright (c) 2012, Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 *
 */

remove_action( 'genesis_footer', 'genesis_do_footer' );

add_action( 'genesis_footer', 'wsm_child_do_footer' );
function wsm_child_do_footer() {

	echo '<div class="footer-left">';
	
	$contact = genesis_get_option( 'wsm_contact_info', 'patricia-settings' );

	if ( !empty($contact ) ) { 		
		echo '<p class="contact-info">' . genesis_get_option( 'wsm_contact_info', 'patricia-settings' ) . '</p>';
	}	
	
	$credit= genesis_get_option( 'wsm_credit', 'patricia-settings' );

	if ( !empty($contact ) ) { 		
		echo '<p class="credit">' . genesis_get_option( 'wsm_credit', 'patricia-settings' ) . '</p>';
	}	
  
	echo '</div><!-- end .footer-left -->';

	echo '<div class="footer-right">';
	
	if ( has_nav_menu( 'footer' ) ) {

			$args = array(
				'theme_location' => 'footer',
				'container' => '',
				'menu_class' => genesis_get_option('nav_superfish') ? 'nav genesis-nav-menu superfish' : 'nav genesis-nav-menu',
				'echo' => 0
			);

			$nav = wp_nav_menu( $args );

		}
		
	$nav_output = sprintf( '<div class="footer-nav">%2$s%1$s%3$s</div>', $nav, genesis_structural_wrap( 'nav', '<div class="menu-wrap">', 0 ), genesis_structural_wrap( 'nav', '</div><!-- end .wrap -->', 0 ) );

	echo apply_filters( 'wsm_do_footer_nav', $nav_output, $nav, $args );
	
	$copyright = genesis_get_option( 'wsm_copyright', 'patricia-settings' );

	if ( !empty( $copyright ) ) { 		
		echo '<p class="copy">' . genesis_get_option( 'wsm_copyright', 'patricia-settings' ) . '</p>';
	}	
	
	echo '</div><!-- end .footer-right -->';

}