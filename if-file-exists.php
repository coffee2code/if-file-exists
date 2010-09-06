<?php
/**
 * @package If_File_Exists
 * @author Scott Reilly
 * @version 2.0
 */
/*
Plugin Name: If File Exists
Version: 2.0
Plugin URI: http://coffee2code.com/wp-plugins/if-file-exists/
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Check if a file exists and return true/false or display a string containing information about the file.

Compatible with WordPress 2.7+, 2.8+, 2.9+, 3.0+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/if-file-exists/

*/

/*
Copyright (c) 2007-2010 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

if ( !function_exists( 'c2c_if_file_exists' ) ) :
/**
 * Checks if a file exists and returns true/false or displays a string
 * containing information about the file.
 *
 * The following percent-tag substitutions are available for optional use in the $format string:
 *   %file_directory% : the directory of the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/"
 *   %file_extension% : the extension of the file, i.e. "zip"
 *   %file_name%      : the name of the file, i.e. "pictures.zip"
 *   %file_url%       : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip";
 *   %file_path%      : the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"
 *
 * @since 2.0
 *
 * @param string $filename Name of the filename whose existence is being checked.
 * @param string $format (optional) Text to be displayed or returned when $filename exists. Leave blank to return true or false.
 * @param bool $echo (optional) Should $format be echoed when the filename exists? NOTE: the string always gets returned unless file does not exist). Default is true.
 * @param string $dir (optional) The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed.
 * @param string $show_if_not_exists (optional) Text to display if the file does not exist. $format must also be specified. Format is the same as $format argument.
 * @return bool|string True/false if no $format is specified, otherwise the percent-tag-substituted $format string.
 */
function c2c_if_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	$error = false;
	$path = '';
	$abspath = ltrim( ABSPATH, '/' );
	$dir = trim( trim( str_replace( $abspath, '', $dir ) ), '/' );
	if ( empty( $dir ) ) {
		$uploads = wp_upload_dir();
		if ( isset( $uploads['error'] ) && !empty( $uploads['error'] ) )
			$error = true;
		else {
			$path = $uploads['path'];
			$dir = str_replace( $abspath, '', $path );
		}
	} elseif ( true == $dir ) {
		// If $dir is set to true, then $filename is already the full path
		$path = dirname( $filename );
		$filename = basename( $filename);
	} else {
		$path = ABSPATH . $dir;
	}

	$full_path = $path . '/' . $filename;
	$exists = ( $error || empty( $filename ) ) ? false : file_exists( $full_path );

	if ( $error ) {
		$format = '';
		echo "<p>ERROR: {$uploads['error']}</p>";
	} elseif ( empty( $format ) ) {
		$format = $exists;
		$echo = false;
	} else {
		if ( !$exists )
			$format = $show_if_not_exists;
		if ( $format ) {
			$pathparts = pathinfo( $full_path );
			$tags = array(
				'%file_directory%' => $pathparts['dirname'],
				'%file_extension%' => $pathparts['extension'],
				'%file_name%'      => $pathparts['basename'],
				'%file_path%'      => $full_path,
				'%file_url%'       => get_option( 'siteurl' ) . '/' . $dir . '/' . $filename
			);
			foreach ( $tags as $tag => $new )
				$format = str_replace( $tag, $new, $format );
		}
	}

	if ( $echo )
		echo $format;
	return $format;
}
apply_filters( 'c2c_if_file_exists', 'c2c_if_file_exists', 10, 5 );
endif;


if ( !function_exists( 'c2c_if_plugin_file_exists' ) ) :
/**
 * Checks if a file exists (relative to the plugin directory) and returns
 * true/false or displays a string containing information about the file.
 *
 * Supports the same percent-tag substitutions as defined for c2c_if_file_exists().
 *
 * @since 2.0
 *
 * @param string $filename
 * @param string $format (optional) Text to be displayed or returned when $filename exists. Leave blank to return true or false.
 * @param bool $echo (optional) Should $format be echoed when the filename exists? NOTE: the string always gets returned unless file does not exist). Default is true.
 * @param string $dir (optional) The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed.
 * @param string $show_if_not_exists (optional) Text to display if the file does not exist. $format must also be specified. Format is the same as $format argument.
 * @return bool|string True/false if no $format is specified, otherwise the percent-tag-substituted $format string.
 */
function c2c_if_plugin_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	$dir = WP_PLUGIN_DIR . '/' . trim( $dir, '/' );
	return c2c_if_file_exists( $filename, $format, $echo, $dir, $show_if_not_exists );
}
apply_filters( 'c2c_if_plugin_file_exists', 'c2c_if_plugin_file_exists', 10, 5 );
endif;


if ( !function_exists( 'c2c_if_theme_file_exists' ) ) :
/**
 * Checks if a file exists (relative to the current theme's directory) and
 * returns true/false or displays a string containing information about the
 * file.  If the current theme is a child theme, then the function will check
 * if the file exists first in the child theme's directory, and if not there,
 * then it will check the parent theme's directory.
 *
 * Supports the same percent-tag substitutions as defined for c2c_if_file_exists().
 *
 * @since 2.0
 *
 * @param string $filename
 * @param string $format (optional) Text to be displayed or returned when $filename exists. Leave blank to return true or false.
 * @param bool $echo (optional) Should $format be echoed when the filename exists? NOTE: the string always gets returned unless file does not exist). Default is true.
 * @param string $dir (optional) The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed.
 * @param string $show_if_not_exists (optional) Text to display if the file does not exist. $format must also be specified. Format is the same as $format argument.
 * @return bool|string True/false if no $format is specified, otherwise the percent-tag-substituted $format string.
 */
function c2c_if_theme_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	$dir = trim( $dir, '/' );
	if ( $dir )
		$filename = $dir . '/' . $filename;
	$filename = locate_template( array( $filename ), false );
	return c2c_if_file_exists( $filename, $format, $echo, true, $show_if_not_exists );
}
apply_filters( 'c2c_if_theme_file_exists', 'c2c_if_theme_file_exists', 10, 5 );
endif;


/**
 * Checks if a file exists and returns true/false or displays a string
 * containing information about the file.
 *
 * @deprecated 2.0 Use the identical, renamed version of this, c2c_if_file_exists(), instead.
 */
if ( !function_exists( 'if_file_exists' ) ) :
function if_file_exists( $filename, $format = '', $echo = true, $dir = '' ) {
	return c2c_if_file_exists( $filename, $format , $echo , $dir );
}
endif;

?>