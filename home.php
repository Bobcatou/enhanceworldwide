<?php 
do_action( 'genesis_home' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_after_header', 'patricia_home_top' ); 
function patricia_home_top() {
	echo '<div class="home-slider">';
		genesis_widget_area( 'rotator', array( 'before' => '<div class="wrap">', 'after' => '</div>') );
	echo'</div>';
}

// Remove the standard loop 
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Execute custom child loop
add_action( 'genesis_loop', 'patricia_home_loop_helper' ); 
function patricia_home_loop_helper() {

	genesis_widget_area( 'home-top', array( 'before' => '<div class="home-top">', 'after' => '</div>') );
	
	echo'<div class="home-cta">';
	genesis_widget_area( 'home-cta1', array( 'before' => '<div class="home-cta1 widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-cta2', array( 'before' => '<div class="home-cta2 widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-cta3', array( 'before' => '<div class="home-cta3 widget-area">', 'after' => '</div>') );
	echo'</div >';
	
	echo'<div class="home-bottom">';
	genesis_widget_area( 'home-bottom1', array( 'before' => '<div class="home-bottom1 widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-bottom2', array( 'before' => '<div class="home-bottom2 widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-bottom3', array( 'before' => '<div class="home-bottom3 widget-area">', 'after' => '</div>') );
	echo'</div >';
}

genesis();