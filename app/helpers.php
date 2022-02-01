<?php 

function mx_sanitize_content( $content = '' ) {

	if ( 0 === strlen( $content ) ) {
		return '';
	}

	$content = htmlspecialchars( $content, ENT_QUOTES );

	return $content;

}