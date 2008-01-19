<?php
/*
Plugin Name: If File Exists
Version: 0.9
Plugin URI: http://www.coffee2code.com/wp-plugins/
Author: Scott Reilly
Author URI: http://www.coffee2code.com
Description: Display an HTML snippet that relates to a file if that file exists.

=>> Visit the plugin's homepage for more information and latest updates  <<=

Installation:

1. Download the file http://www.coffee2code.com/wp-plugins/if-file-exists.zip
2. Activate the plugin from your WordPress admin 'Plugins' page.
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
		
*/

/*
Copyright (c) 2007 by Scott Reilly (aka coffee2code)

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
	$format : a string to be displayed and/or returned when $filename exists.  The following percent-tag substutitions exist for
		use: %file_name%, %file_url%, %file_path% (see documentation above for more details).  If this argument is not provided,
		then true or false is returned to indicate if the file exists.
	$echo : should the $format string be echoed when the filename exists? (NOTE: the string always gets returned unless file does not exist)
		If the argument is not provided, the format will be echoed.
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
		$format = "<div>The file $filename was not found</div>";
	}

	if ($echo)
		echo $format;
	return $format;
}

?>