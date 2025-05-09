<?php
/**
 * Plugin Name: If File Exists
 * Version:     2.4
 * Plugin URI:  https://coffee2code.com/wp-plugins/if-file-exists/
 * Author:      Scott Reilly
 * Author URI:  https://coffee2code.com/
 * Text Domain: if-file-exists
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Check if a file exists and return true/false or display a string containing information about the file.
 *
 * Compatible with WordPress 2.7 through 6.8+, and PHP through at least 8.3+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/if-file-exists/
 *
 * @package If_File_Exists
 * @author  Scott Reilly
 * @version 2.4
 */

/*
	Copyright (c) 2007-2025 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! function_exists( 'c2c_if_file_exists' ) ) :
/**
 * Checks if a file exists.
 *
 * The following percent-tag substitutions are available for optional use in the $format string:
 *   %file_directory% : the directory of the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/"
 *   %file_extension% : the extension of the file, i.e. "zip"
 *   %file_name%      : the name of the file, i.e. "pictures.zip"
 *   %file_size%      : the size of the file, in number of bytes to the largest unit the bytes will fit into, rounded to 2 decimal places, i.e. "1.24 MB"
 *   $file_size_byees%: the size of the file, in bytes
 *   %file_url%       : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip";
 *   %file_path%      : the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"
 *
 * @since 2.0
 *
 * @param string      $filename           The name of the file to check for.
 * @param string      $format             Optional. Text to be displayed or
 *                                        returned when $filename exists. Leave
 *                                        blank to return true or false. Default ''.
 * @param bool        $echo               Optional. Should $format be echoed when
 *                                        the filename exists? NOTE: the string
 *                                        always gets returned unless file does
 *                                        not exist). Default true.
 * @param string|bool $dir                Optional. The directory (relative to the
 *                                        current child or parent theme) to check
 *                                        for $filename. If 'true', then it
 *                                        indicates the filename includes the
 *                                        directory. Default ''.
 * @param string      $show_if_not_exists Optional. Text to display if the file
 *                                        does not exist. $format must also be
 *                                        specified. Format is the same as $format
 *                                        argument. Default ''.
 * @return bool|string True/false if no $format is specified, otherwise the
 *                     percent-tag-substituted $format string.
 */
function c2c_if_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	$error   = false;
	$path    = '';
	$abspath = ltrim( ABSPATH, '/' );

	if ( ! is_bool( $dir ) ) {
		$dir = trim( trim( str_replace( $abspath, '', $dir ) ), '/' );
	}

	if ( false === $dir || empty( $dir ) ) {
		$uploads = wp_upload_dir();
		if ( isset( $uploads['error'] ) && ! empty( $uploads['error'] ) ) {
			$error = true;
		} else {
			$path = $uploads['path'];
			$dir = str_replace( $abspath, '', $path );
		}
	} elseif ( true === $dir ) {
		// If $dir is set to true, then $filename is already the full path
		$path = dirname( $filename );
		$filename = basename( $filename );
		$dir = str_replace( ABSPATH, '', $path );
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
		$echo   = false;
	} else {
		if ( ! $exists ) {
			$format = $show_if_not_exists;
		}

		if ( $format ) {
			$pathparts = pathinfo( $full_path );
			$tags = array(
				'%file_directory%' => $pathparts['dirname'],
				'%file_extension%' => isset( $pathparts['extension'] ) ? $pathparts['extension'] : '',
				'%file_name%'      => $pathparts['basename'],
				'%file_path%'      => $full_path,
				'%file_size%'      => str_replace( '.00', '', size_format( wp_filesize( $full_path ), 2 ) ),
				'%file_size_bytes%'=> wp_filesize( $full_path ),
				'%file_url%'       => site_url() . '/' . $dir . '/' . $filename
			);

			foreach ( $tags as $tag => $new ) {
				$format = str_replace( $tag, $new, $format );
			}
		}
	}

	if ( $echo ) {
		echo wp_kses_post( $format );
	}

	return $format;
}
add_filter( 'c2c_if_file_exists', 'c2c_if_file_exists', 10, 5 );
endif;


if ( ! function_exists( 'c2c_if_plugin_file_exists' ) ) :
/**
 * Checks if a file exists relative to the plugins directory.
 *
 * Supports the same percent-tag substitutions as defined for `c2c_if_file_exists()`.
 *
 * @since 2.0
 *
 * @param string      $filename           The name of the file to check for.
 * @param string      $format             Optional. Text to be displayed or
 *                                        returned when $filename exists. Leave
 *                                        blank to return true or false. Default ''.
 * @param bool        $echo               Optional. Should $format be echoed when
 *                                        the filename exists? NOTE: the string
 *                                        always gets returned unless file does
 *                                        not exist). Default true.
 * @param string|bool $dir                Optional. The directory (relative to the
 *                                        current child or parent theme) to check
 *                                        for $filename. If 'true', then it
 *                                        indicates the filename includes the
 *                                        directory. Default ''.
 * @param string      $show_if_not_exists Optional. Text to display if the file
 *                                        does not exist. $format must also be
 *                                        specified. Format is the same as $format
 *                                        argument. Default ''.
 * @return bool|string True/false if no $format is specified, otherwise the
 *                     percent-tag-substituted $format string.
 */
function c2c_if_plugin_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	if ( true === $dir ) {
		$filename = WP_PLUGIN_DIR . '/' . trim( $filename, '/' );
	} elseif ( ! empty( $dir ) && ! is_bool( $dir ) ) {
		$dir = WP_PLUGIN_DIR . '/' . trim( $dir, '/' );
	} else {
		$dir = WP_PLUGIN_DIR;
	}

	return c2c_if_file_exists( $filename, $format, $echo, $dir, $show_if_not_exists );
}
add_filter( 'c2c_if_plugin_file_exists', 'c2c_if_plugin_file_exists', 10, 5 );
endif;


if ( ! function_exists( 'c2c_if_theme_file_exists' ) ) :
/**
 * Checks if a file exists relative to the current theme's directory.
 *
 * Returns true/false or displays a string containing information about the
 * file. If the current theme is a child theme, then the function will check
 * if the file exists first in the child theme's directory, and if not there,
 * then it will check the parent theme's directory.
 *
 * Supports the same percent-tag substitutions as defined for `c2c_if_file_exists()`.
 *
 * @since 2.0
 *
 * @param string      $filename           The name of the file to check for.
 * @param string      $format             Optional. Text to be displayed or
 *                                        returned when $filename exists. Leave
 *                                        blank to return true or false. Default ''.
 * @param bool        $echo               Optional. Should $format be echoed when
 *                                        the filename exists? NOTE: the string
 *                                        always gets returned unless file does
 *                                        not exist). Default true.
 * @param string|bool $dir                Optional. The directory (relative to the
 *                                        current child or parent theme) to check
 *                                        for $filename. If 'true', then it
 *                                        indicates the filename includes the
 *                                        directory. Default ''.
 * @param string      $show_if_not_exists Optional. Text to display if the file
 *                                        does not exist. $format must also be
 *                                        specified. Format is the same as $format
 *                                        argument. Default ''.
 * @return bool|string True/false if no $format is specified, otherwise the
 *                     percent-tag-substituted $format string.
 */
function c2c_if_theme_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
	if ( ! is_bool( $dir ) ) {
		$dir = trim( $dir, '/' );
		if ( $dir ) {
			$filename = $dir . '/' . $filename;
		}
	}

	$filename = locate_template( array( $filename ), false );

	return c2c_if_file_exists( $filename, $format, $echo, true, $show_if_not_exists );
}
add_filter( 'c2c_if_theme_file_exists', 'c2c_if_theme_file_exists', 10, 5 );
endif;
