<?php
/**
 * @package If_File_Exists
 * @author Scott Reilly
 * @version 2.1
 */
/*
Plugin Name: If File Exists
Version: 2.1
Plugin URI: http://coffee2code.com/wp-plugins/if-file-exists/
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Check if a file exists and return true/false or display a string containing information about the file.

Compatible with WordPress 2.7+, 2.8+, 2.9+, 3.0+, 3.1+, 3.2+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/if-file-exists/

*/

/*
Copyright (c) 2007-2011 by Scott Reilly (aka coffee2code)

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

if ( ! function_exists( 'c2c_if_file_exists' ) ) :
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
 * @param string|bool $dir (optional) The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed. If 'true', then it indicates the filename includes the directory.
 * @param string $show_if_not_exists (optional) Text to display if the file does not exist. $format must also be specified. Format is the same as $format argument.
 * @return bool|string True/false if no $format is specified, otherwise the percent-tag-substituted $format string.
 */
function c2c_if_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	$error = false;
	$path = '';
	$abspath = ltrim( ABSPATH, '/' );
	if ( ! is_bool( $dir ) )
		$dir = trim( trim( str_replace( $abspath, '', $dir ) ), '/' );
	if ( false === $dir || empty( $dir ) ) {
		$uploads = wp_upload_dir();
		if ( isset( $uploads['error'] ) && ! empty( $uploads['error'] ) )
			$error = true;
		else {
			$path = $uploads['path'];
			$dir = str_replace( $abspath, '', $path );
		}
	} elseif ( true === $dir ) {
		// If $dir is set to true, then $filename is already the full path
		$path = dirname( $filename );
		$filename = basename( $filename );
	} else {
		$path = ABSPATH . $dir;
	}
	$full_path = $path . '/' . $filename;
	$exists = ( $error || empty( $filename ) ) ? false : file_exists( $full_path );

//	if ( $error ) {
//		$format = '';
//		echo "<p>ERROR: {$uploads['error']}</p>";
//	} else
	if ( empty( $format ) ) {
		$format = $exists;
		$echo = false;
	} else {
		if ( ! $exists )
			$format = $show_if_not_exists;
		if ( $format ) {
			$pathparts = pathinfo( $full_path );
			$tags = array(
				'%file_directory%' => $pathparts['dirname'],
				'%file_extension%' => isset( $pathparts['extension'] ) ? $pathparts['extension'] : '',
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


if ( ! function_exists( 'c2c_if_plugin_file_exists' ) ) :
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
 * @param string|bool $dir (optional) The directory (relative to the plugins directory) to check for $filename. If empty, the WordPress upload directory is assumed. If 'true', then it indicates the filename includes the directory.
 * @param string $show_if_not_exists (optional) Text to display if the file does not exist. $format must also be specified. Format is the same as $format argument.
 * @return bool|string True/false if no $format is specified, otherwise the percent-tag-substituted $format string.
 */
function c2c_if_plugin_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	if ( true === $dir )
		$filename = WP_PLUGIN_DIR . '/' . trim( $filename, '/' );
	elseif ( ! empty( $dir ) && ! is_bool( $dir ) )
		$dir = WP_PLUGIN_DIR . '/' . trim( $dir, '/' );
	return c2c_if_file_exists( $filename, $format, $echo, $dir, $show_if_not_exists );
}
apply_filters( 'c2c_if_plugin_file_exists', 'c2c_if_plugin_file_exists', 10, 5 );
endif;


if ( ! function_exists( 'c2c_if_theme_file_exists' ) ) :
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
 * @param string|bool $dir (optional) The directory (relative to the current child or parent theme) to check for $filename. If empty, the WordPress upload directory is assumed. If 'true', then it indicates the filename includes the directory.
 * @param string $show_if_not_exists (optional) Text to display if the file does not exist. $format must also be specified. Format is the same as $format argument.
 * @return bool|string True/false if no $format is specified, otherwise the percent-tag-substituted $format string.
 */
function c2c_if_theme_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	if ( ! is_bool( $dir ) ) {
		$dir = trim( $dir, '/' );
		if ( $dir )
			$filename = $dir . '/' . $filename;
	}
	$filename = locate_template( array( $filename ), false );
	return c2c_if_file_exists( $filename, $format, $echo, true, $show_if_not_exists );
}
apply_filters( 'c2c_if_theme_file_exists', 'c2c_if_theme_file_exists', 10, 5 );
endif;

if ( ! function_exists( 'c2c_test_if_file_exists' ) ) :
/**
 * Simplistic unit test for If File Exists public functions.
 *
 * Outputs test results in a list. Each test is numbered and should PASS.
 *
 * TODO:
 * * Check if default upload dir exists. If so, then find a good file therein.
 *   That way this can test default behaviors when no path is explicit
 *
 * @since 2.1
 */
function c2c_test_if_file_exists() {
	$path            = dirname( __FILE__ );
	$good_file       = basename( __FILE__ );
	$bad_file        = 'nonexistent-file.xyz';
	$good_theme_file = 'style.css';
	$good_msg        = '%file_name% does exist';
	$good_msg_result = $good_file . ' does exist';
	$bad_msg         = '%file_name% does not exist';
	$bad_msg_result  = $bad_file . ' does not exist';
	$full_msg        = "path=(%file_path%), name=(%file_name%), ext=(%file_extension%), dir=(%file_directory%), url=(%file_url%)";
	$full_msg_result = "path=($path/$good_file), name=($good_file), ext=(php), dir=($path), url=(" . plugins_url( $good_file, __FILE__ ) . ")";

	$i = 1;
	echo '<ul>';

	// Test basic invocation with bad file
	$result = c2c_if_file_exists( $path . '/' . $bad_file ) === false;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test basic invocation with bad file
	$result = c2c_if_file_exists( $bad_file ) === false;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test good file with explicit directory
	$result = c2c_if_file_exists( $good_file, '', false, $path ) === true;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test bad file with explicit directory
	$result = c2c_if_file_exists( $bad_file, '', false, $path ) === false;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test bad file with false as directory (can't test true since we can't assume default upload dir exists)
	$result = c2c_if_file_exists( $path . '/' . $bad_file, '', false, false ) === false;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test good file with full path
	$result = c2c_if_file_exists( $path . '/' . $good_file, '', false, true ) === true;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test bad file with full path
	$result = c2c_if_file_exists( $path . '/' . $bad_file, '', false, true ) === false;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test string output with good file
	ob_start();
	c2c_if_file_exists( $good_file, $good_msg, true, $path, $bad_msg );
	$result_msg = ob_get_contents();
	ob_end_clean();
	$result = $result_msg == $good_msg_result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result";
	if ( 'FAIL' == $result )
		echo " <br /><code>$result_msg</code><br />does not equal expected<br /><code>$good_msg_result</code>";
	echo "</li>";
	$i++;

	// Test no output with bad file
	ob_start();
	c2c_if_file_exists( $bad_file, $good_msg, true, $path );
	$result_msg = ob_get_contents();
	ob_end_clean();
	$result = empty( $result_msg ) ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result";
	if ( 'FAIL' == $result )
		echo " <br /><code>$result_msg</code><br />does not equal expected<br />(empty string)";
	echo "</li>";
	$i++;

	// Test string output with bad file
	ob_start();
	c2c_if_file_exists( $bad_file, $good_msg, true, $path, $bad_msg );
	$result_msg = ob_get_contents();
	ob_end_clean();
	$result = $result_msg == $bad_msg_result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result";
	if ( 'FAIL' == $result )
		echo " <br /><code>$result_msg</code><br />does not equal expected<br /><code>$bad_msg_result</code>";
	echo "</li>";
	$i++;

	// Test all substitution tags in string output with good file
	ob_start();
	c2c_if_file_exists( $good_file, $full_msg, true, $path, $bad_msg );
	$result_msg = ob_get_contents();
	ob_end_clean();
	$result = $result_msg == $full_msg_result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result";
	if ( 'FAIL' == $result )
		echo " <br />\n<code>$result_msg</code><br />\ndoes not equal expected<br />\n<code>$full_msg_result</code>";
	echo "</li>";
	$i++;

	// Test c2c_if_plugin_file_exists invocation with bad file
	$result = c2c_if_plugin_file_exists( $bad_file ) === false;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test c2c_if_plugin_file_exists invocation with good file
	$result = c2c_if_plugin_file_exists( $good_file, '', false, basename( $path ) ) === true;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test c2c_if_plugin_file_exists invocation with full path good file
	$result = c2c_if_plugin_file_exists( basename( $path ) . '/' . $good_file, '', false, true ) === true;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// Test c2c_if_theme_file_exists invocation with good file
	$result = c2c_if_theme_file_exists( $good_theme_file ) === true;
	$result = $result ? 'PASS' : 'FAIL';
	echo "<li>Test #$i: $result</li>";
	$i++;

	// TODO: Test that if a $dir is specified, it is relative to child|parent theme dir

	echo '</ul>';
}
endif;

/**
 * Checks if a file exists and returns true/false or displays a string
 * containing information about the file.
 *
 * @deprecated 2.0 Use the identical, renamed version of this, c2c_if_file_exists(), instead.
 */
if ( ! function_exists( 'if_file_exists' ) ) :
function if_file_exists( $filename, $format = '', $echo = true, $dir = '' ) {
	_deprecated_function( __FUNCTION__, '2.0', 'c2c_if_file_exists' );
	return c2c_if_file_exists( $filename, $format , $echo , $dir );
}
endif;

?>