=== If File Exists ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: file, exists, existence, check, presence, files, coffee2code
Requires at least: 1.5
Tested up to: 2.9.1
Stable tag: 1.0.3
Version: 1.0.3

Check if a file exists and return true/false or display a string containing information about the file.

== Description ==

Check if a file exists and return true/false or display a string containing information about the file.

If a format string is not passed to it, the function `if_file_exists()` returns a simple boolean (true or false) indicating if the specified file exists.

Otherwise, the format string provided to it will be used to construct a response string, which can be customized to display information about the file (such as file_name, file_url, or file_path).  If the `$echo` argument is true, that string is displayed on the page.  Regardless of the value of `$echo`, the response string is returned by the function.

By default, the function assumes you are looking for the file in the default WordPress upload directory.  If you wish to search another directory, specify it as the $dir argument and not as a path attached to the filename.

== Installation ==

1. Unzip `if-file-exists.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. In one or more of your templates, utilize the template tag provided by this plugin (see examples)

== Template Tags ==

The plugin provides one template tag for use in your theme templates.

= Functions =

* `<?php function if_file_exists($filename, $format = '', $echo = true, $dir = '') ?>`

= Arguments =

* `$filename`
Name of the filename whose existence is being checked.  Do not include path information.

* `$format`
(optional) String to be displayed or returned when $filename exists. Leave blank to return true or false.  The following percent-tag substitutions are available for optional use in the $format string:
	`%file_name%` : the name of the file, i.e. "pictures.zip"
	`%file_url%` : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip";
	`%file_path%`: the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"

* `$echo`
(optional) Should `$format` be echoed when the filename exists? NOTE: the string always gets returned unless file does not exist). Default is true.

* `$dir`
(optional) The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed.

= Examples =

* `<?php
	if ( if_file_exists($file_name) ) {
		// Do stuff here
	}
	?>`

* `<?php if_file_exists($file_name, '%file_name% exists!'); ?>`

* `<?php if_file_exists($file_name, '%file_name% also exists in upload2 directory', 'wp-content/uploads2'); ?>`

== Changelog ==

= 1.0.3 =
* Add PHPDoc documentation
* Change description and update documentation
* Minor formatting tweaks
* Note compatibility with WP 2.9+
* Update copyright date
* Update readme.txt (including adding Changelog)

= 1.0.2 =
* Note compatibility with WP 2.8+

= 1.0.1 =
* Note compatibility with WP 2.6+, 2.7+

= 1.0 =
* Initial release