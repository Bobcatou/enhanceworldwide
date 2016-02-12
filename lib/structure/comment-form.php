<?php
/**
 * Patricia Comment Form
 * 
 * This file calls the defines the output for the HTML5 blog comment form.
 *
 * @category     Patricia
 * @package      Structure
 * @author       Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.1.0
 */


// Set the Comment Form Defaults
add_filter( 'comment_form_defaults', 'wsm_comment_form_defaults' );
function wsm_comment_form_defaults( $fields ) {
	
    $fields['comment_notes_before'] = ''; //Removes Email Privacy Notice
    $fields['title_reply'] = __( 'Leave a Comment', 'patricia' ); //Changes The Form Headline
    $fields['comment_field'] = '<p class="gforms-placeholder comment-form-comment"><label for="comment">' . __( 'Comment', 'patricia' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" tabindex="4"></textarea></p>'; // Adds clearit class and default value to comment text area
    $fields['label_submit'] = __( 'Submit', 'patricia' ); //Changes The Submit Button Text
    $fields['comment_notes_after'] = ''; //Removes Form Allowed Tags Box
    
    return $fields;
  
}

// Set the Comment Form fields
add_filter( 'comment_form_default_fields', 'wsm_comment_form_fields' );
function wsm_comment_form_fields( $fields ) {
	
	global $commenter, $req, $aria_req;
	
	$req      = get_option( 'require_name_email' );
	
	$fields   =  array(
		
		'author' => '<label for="author">' . __( 'Name', 'patricia' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> <p class="gforms-placeholder comment-form-author"><input id="author" name="author" type="text" value="" size="30"' . $aria_req . ' tabindex="1" /></p>',
		
		'email'  => '<label for="email">' . __( 'Email', 'patricia' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> <p class="gforms-placeholder comment-form-email"><input id="email" name="email" type="email" value="" size="30"' . $aria_req . ' tabindex="2" /></p>',
		
		'url'    => '<label for="url">' . __( 'Website', 'patricia' ) . '</label> <p class="gforms-placeholder comment-form-url"><input id="url" name="url" type="url" value="" size="30" tabindex="3" /></p>',
	);
	
	return $fields;
	
}