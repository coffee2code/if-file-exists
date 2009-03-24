=== If File Exists ===
Contributors: coffee2code
Donate link: http://coffee2code.com
Tags: file, existence
Requires at least: 1.5
Tested up to: 2.7.1
Stable tag: trunk
Version: 1.0.1

Check for the existence of a file and return simple boolean state or display an HTML snippet containing information about the file.

== Description ==

Check for the existence of a file and return simple boolean state or display an HTML snippet containing information about the file.

If a format string is not passed to it, the function `if_file_exists()` returns a simple boolean (true or false) indicating if the specified file exists.

Otherwise, the format string provided to it will be used to construct a response string, which can be customized to display information about the file (such as file_name, file_url, or file_path).  If the `$echo` argument is true, that string is displayed on the page.  Regardless of the value of `$echo`, the response string is returned by the function.

By default, the function assumes you are looking for the file in the default WordPress upload directory.  If you wish to search another directory, specify it as the $dir argument and not as a path attached to the filename.

== Installation ==

1. Unzip `if-file-exists.zip` inside the `/wp-content/plugins/` directory, or copy `if-file-exists.php` into `/wp-content/plugins/`
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. In one or more of your templates, utilize the template tag provided by this plugin (see examples)

== Template Tags ==

The plugin provides one template tag for use in your theme templates.

= Functions =

* `<?php function if_file_exists($filename, $format = '', $echo = true, $dir = '') ?>`

= Arguments =

* `$filename`
The name of the filename whose existence is being checked for.  Do not include path information.

* `$format`
(optional) A string to be displayed and/or returned when $filename exists.  The following percent-tag substitutions exist for use: `%file_name%`, `%file_url%`, `%file_path%`.  If this argument is not provided, then true or false is returned to indicate if the file exists.
	Available percent-tag substitutions for the $format argument are :
	`%file_name%` : the name of the file, i.e. "pictures.zip"
	`%file_url%` : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip";
	`%file_path%`: the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"

* `$echo`
(optional) Should the `$format` string be echoed when the filename exists? (NOTE: the string always gets returned unless file does not exist).  If the argument is not provided but a `$format` is provided, the format will be echoed.

* `$dir`
(optional) If empty, it assumes the WordPress upload directory.  NOTE: This is a directory relative to the root of the site.

= Examples =

* `<?php if (if_file_exists($file_name)) :
	// Do stuff here
?>`

* `<?php if_file_exists($file_name, '%file_name% exists!'); ?>`

* `<?php if_file_exists($file_name, '%file_name% also exists in upload2 directory', 'wp-content/uploads2'); ?>`
