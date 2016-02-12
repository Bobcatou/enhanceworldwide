<?php

// Script for adding placeholders to HTML5 Gravity Forms fields
add_action( 'wp_footer', 'wsm_gforms_placeholder_script' );
function wsm_gforms_placeholder_script() { ?>

<script>
// Start allowance of jQuery to $ shortcut
(function($) {

	// Convert label to placeholder
	<?php
		$gform_class_pc = genesis_get_option( 'wsm_gforms_placeholder', 'patricia-settings' );
		if ($gform_class_pc) {
			$gform_class = 'gforms-placeholder';
		}
		else {
			$gform_class = 'gform_wrapper';
		}
	?>
	$.each($('.<?php echo $gform_class; ?> input, .<?php echo $gform_class; ?> textarea'), function () {
		var gfapId = this.id;
		var gfapLabel = $('label[for=' + gfapId + ']');
		$(gfapLabel).hide();
		var gfapLabelValue = $(gfapLabel).text();
		$(this).attr('placeholder',gfapLabelValue);
	});

	// Use modernizr to add placeholders for IE
	if(!Modernizr.input.placeholder){$("input,textarea").each(function(){if($(this).val()=="" && $(this).attr("placeholder")!=""){$(this).val($(this).attr("placeholder"));$(this).focus(function(){if($(this).val()==$(this).attr("placeholder")) $(this).val("");});$(this).blur(function(){if($(this).val()=="") $(this).val($(this).attr("placeholder"));});}});}

// Ends allowance of jQuery to $ shortcut
})( jQuery );
</script>

<?php

}