<?php
/*
Plugin Name: If File Exists
Version: 1.0.1
Plugin URI: http://coffee2code.com/wp-plugins/if-file-exists
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Check for the existence of a file and return simple boolean value or display an HTML snippet containing information about the file.

If a format string is not passed to it, the function if_file_exists() returns a simple boolean (true or false)
indicating if the specified file exists.

Otherwise, the format string provided to it will be used to construct a response string, which can be customized
to display information about the file (such as file_name, file_url, or file_path).  If the $echo argument is true, 
that string is displayed on the page.  Regardless of the value of $echo, the response string is returned by the 
function.

By default, the function assumes you are looking for the file in the default WordPress upload directory.  If you
wish to search another directory, specify it as the $dir argument and not as a path attached to the filename.

Compatible with WordPress 1.5+, 2.0+, 2.1+, 2.2+, 2.3+, 2.5+, 2.6+, 2.7+, 2.8+.

=>> Read the accompanying readme.txt file for more information.  Also, visit the plugin's homepage
=>> for more information and the latest updates

Installation:

1. Download the file http://coffee2code.com/wp-plugins/if-file-exists.zip and unzip it into your 
/wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. In one or more of your templates, utilize the template tag provided by this plugin like so:

	<?php
		$format = "<a href='%file_url%'>Download %file_name% now!</a>";
		$file_name = 'pictures-' . get_the_ID() . '.zip';
		if_file_exists($file_name, $format);
	?>
	
	Available percent-tag substitutions for the $format argument are :
		%file_name% : the name of the file, i.e. "pictures.zip"
		%file_url% : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip";
		%file_path% : the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"

Examples:

<?php if (if_file_exists($file_name)) :
	// Do stuff here
?>

<?php if_file_exists($file_name, '%file_name% exists!'); ?>

<?php if_file_exists($file_name, '%file_name% also exists in upload2 directory', 'wp-content/uploads2'); ?>

*/

/*
Copyright (c) 2007-2009 by Scott Reilly (aka coffee2code)

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

/*
	Arguments:
	$filename : the name of the filename whose existence is being checked for
	$format : a string to be displayed and/or returned when $filename exists.  The following percent-tag substitutions exist for
		use: %file_name%, %file_url%, %file_path% (see documentation above for more details).  If this argument is not provided,
		then true or false is returned to indicate if the file exists.
	$echo : should the $format string be echoed when the filename exists? (NOTE: the string always gets returned unless file does not exist);  If the argument is not provided but a $format is provided, the format will be echoed.
	$dir : if empty, it assumes the WordPress upload directory.  NOTE: This is a directory relative to the root of the site.
*/
function if_file_exists($filename, $format = '', $echo = true, $dir = '') {
	if (empty($dir)) {
		$uploads = wp_upload_dir();
		$path = $uploads['path'];
		$dir = str_replace(ABSPATH, '', $path);
	} else {
		$path = ABSPATH . $dir;
	}

	$exists = file_exists($path . '/' . $filename);
	
	if (empty($format)) {
		$format = $exists;
		$echo = false;
	} elseif ($exists) {
		$tags = array(
			'%file_name%' => $filename,
			'%file_path%' => $path . '/' . $filename,
			'%file_url%' => get_bloginfo('siteurl') . '/' . $dir . '/' . $filename
		);
		foreach ($tags as $tag => $new) {
			$format = str_replace($tag, $new, $format);
		}
	} else {
		//$format = "<div>The file $filename was not found</div>";
		$format = '';
	}

	if ($echo)
		echo $format;
	return $format;
}

?>