<?php

if ( !function_exists('pa') ) {
	function pa( $mixed, $stop = false ) {
		$ar = debug_backtrace(); $key = pathinfo($ar[0]['file']); $key = $key['basename'] . ':' . $ar[0]['line'];
		$print = array( $key => $mixed ); echo( '<pre>' . htmlentities(print_r($print, 1)) . '</pre>' );
		if ( $stop == 1 )
			exit();
	}
}

/**
 * Json formater
 * @param string $json Data of settings for fields
 * @return string Return formated json string with settings for fields
 */
function jtmce_format_json( $json ) {
	$result = '';
	$level = 0;
	$in_quotes = false;
	$in_escape = false;
	$ends_line_level = NULL;
	$json_length = strlen( $json );

	for( $i = 0; $i < $json_length; $i++ ) {
		$char = $json[$i];
		$new_line_level = NULL;
		$post = "";
		if( $ends_line_level !== NULL ) {
			$new_line_level = $ends_line_level;
			$ends_line_level = NULL;
		}
		if ( $in_escape ) {
			$in_escape = false;
		} else if( $char === '"' ) {
			$in_quotes = !$in_quotes;
		} else if( ! $in_quotes ) {
			switch( $char ) {
				case '}': case ']':
				$level--;
				$ends_line_level = NULL;
				$new_line_level = $level;
				break;

				case '{': case '[':
				$level++;
				case ',':
					$ends_line_level = $level;
					break;

				case ':':
					$post = " ";
					break;

				case " ": case "\t": case "\n": case "\r":
				$char = "";
				$ends_line_level = $new_line_level;
				$new_line_level = NULL;
				break;
			}
		} else if ( $char === '\\' ) {
			$in_escape = true;
		}
		if( $new_line_level !== NULL ) {
			$result .= "\n".str_repeat( "\t", $new_line_level );
		}
		$result .= $char.$post;
	}

	return $result;
}

/**
 * Set permisiions for file
 * @param string $dir Parent directory path
 * @param string $filename File path
 * @return boolean
 */
function jtmce_set_chmod( $filename ) {
	$dir_perms = fileperms(dirname($filename));
	if ( @chmod($filename, $dir_perms) ) {
		return true;
	}
	else {
		return false;
	}
}