=== If File Exists ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: file, exists, existence, check, presence, files, theme, template tag, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 2.7
Tested up to: 4.0
Stable tag: 2.2.1

Check if a file exists and return true/false or display a string containing information about the file.


== Description ==

This plugin provides the function `c2c_if_file_exists()` (and a couple others) that check if a file exists and either returns true/false or displays a string containing information about the file.

If a format string is not passed to it, the functions return a simple boolean (true or false) indicating if the specified file exists.

Otherwise, the format string provided to it will be used to construct a response string, which can be customized to display information about the file (such as file_name, file_url, or file_path). If the `$echo` argument is true, that string is displayed on the page. Regardless of the value of `$echo`, the response string is returned by the function.

By default, 'c2c_if_file_exists()' assumes you are looking for the file relative to the default WordPress upload directory. If you wish to search another directory, specify it as the $dir argument. 'c2c_if_theme_file_exists()' assumes you are looking for a file relative to the currently active theme's home directory. 'c2c_if_plugin_file_exists()' assumes you are looking for a file relative to the directory that contains WordPress plugins.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/if-file-exists/) | [Plugin Directory Page](https://wordpress.org/plugins/if-file-exists/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Unzip `if-file-exists.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. In one or more of your templates, utilize one of the template tags provided by this plugin (see examples)


== Template Tags ==

The plugin provides three template tags for use in your theme templates.

= Functions =

* `<?php function c2c_if_file_exists($filename, $format = '', $echo = true, $dir = '') ?>`
Checks if a file exists and returns true/false or displays a string containing information about the file.
* `<?php function c2c_if_plugin_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) ?>`
Checks if a file exists (relative to the plugins directory) and returns true/false or displays a string containing information about the file.
* `<?php function c2c_if_theme_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) ?>`
Checks if a file exists (relative to the current theme's directory) and returns true/false or displays a string containing information about the file. If the current theme is a child theme, then the function will check if the file exists first in the child theme's directory, and if not there, then it will check the parent theme's directory.

= Arguments =

* `$filename`
String. Name of the filename whose existence is being checked. Do not include path information.

* `$format`
(optional) String. Text to be displayed or returned when $filename exists. Leave blank to return true or false. The following percent-tag substitutions are available for optional use in the $format string:
    * `%file_directory%` : the directory of the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/"
    * `%file_extension%` : the extension of the file, i.e. "zip"`
    * `%file_name%` : the name of the file, i.e. "pictures.zip"
    * `%file_url%` : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip"
    * `%file_path%`: the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"

* `$echo`
(optional) Boolean. Should `$format` be echoed when the filename exists? NOTE: the string always gets returned unless file does not exist). Default is true.

* `$dir`
(optional) String|Boolean. The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed (if using `c2c_if_file_exists()`). If 'true', then it indicates the filename includes the directory.

* `$show_if_not_exists`
(optional) String. Text to display if the file does not exists. $format must also be specified. Format is the same as $format argument.

= Examples =

* `<?php
$format = "<a href='%file_url%'>Download %file_name% now!</a>";
$file_name = 'pictures-' . get_the_ID() . '.zip';
c2c_if_file_exists($file_name, $format);
?>`

* `<?php
if ( c2c_if_file_exists($file_name) ) {
   // Do stuff here
}
?>`

* `<?php c2c_if_file_exists($file_name, '%file_name% exists!'); ?>`

* `<?php c2c_if_file_exists($file_name, '%file_name% also exists in upload2 directory', true, 'wp-content/uploads2'); ?>`

* `<?php c2c_if_file_exists($file_name, '%file_name% also exists in upload2 directory', true, 'wp-content/uploads2', '%file_name% did not exist!'); ?>`

* `<?php c2c_if_plugin_file_exists('akismet.php', 'Akismet is present', true, 'akismet'); ?>`

* `<?php c2c_if_plugin_file_exists('akismet/akismet.php', 'Akismet is present', true, true); ?>`

* `<?php c2c_if_theme_file_exists('home.php', 'Home template is present', true, '', 'Home template does not exist.'); ?>`


== Filters ==

The plugin exposes three filters for hooking. Typically, customizations utilizing these hooks would be put into your active theme's functions.php file, or used by another plugin.

= c2c_if_file_exists (filter) =

The 'c2c_if_file_exists' hook allows you to use an alternative approach to safely invoke `c2c_if_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_if_file_exists()`

Example:

Instead of:

`<?php c2c_if_file_exists( $file, '%file_url%' ); ?>`

Do:

`<?php apply_filters( 'c2c_if_file_exists', $file, '%file_url%' ); ?>`

= c2c_if_plugin_file_exists (filter) =

The 'c2c_if_plugin_file_exists' hook allows you to use an alternative approach to safely invoke `c2c_if_plugin_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_if_plugin_file_exists()`

Example:

Instead of:

`<?php $exists = c2c_if_plugin_file_exists( $file ); ?>`

Do:

`<?php $exists = apply_filters( 'c2c_if_plugin_file_exists', $file ); ?>`

= c2c_if_theme_file_exists (filter) =

The 'c2c_if_theme_file_exists' hook allows you to use an alternative approach to safely invoke `c2c_if_theme_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_if_theme_file_exists()`

Example:

Instead of:

`<?php $exists = c2c_if_theme_file_exists( $file ); ?>`

Do:

`<?php $exists = apply_filters( 'c2c_if_theme_file_exists', $file ); ?>`


== Changelog ==

= 2.2.1 (2014-08-31) =
* Minor plugin header reformatting
* Minor code reformatting (spacing, bracing)
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

= 2.2 (2013-12-29) =
* Fix to set $dir to directory when passed as part of filename and not via $dir arg
* Fix in c2c_if_plugin_file_exists() to ensure files are relative to WP_PLUGIN_DIR
* Fix to use add_filter() instead of apply_filters() to enable filter invocation technique
* Convert existing makeshift unit tests to PHPUnit unit tests
* Remove c2c_test_if_file_exists()
* Use site_url() to get site URL instead of the option
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Minor readme.txt tweaks
* Change donate link
* Add banner

= 2.1.3 =
* Add check to prevent execution of code if file is directly accessed
* Minor changes to extended description
* Minor code reformatting (spacing)
* Note compatibility through WP 3.5+
* Update copyright date (2013)

= 2.1.2 =
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

= 2.1.1 =
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 2.1 =
* Minor bugfix to prevent PHP warning when a file has no extension
* Fix all functions to properly handle boolean $dir argument
* Add c2c_test_if_file_exists() to perform some (15) simple tests on the provided functions
* Disable unnecessarily outputting error message when default upload directory is not present -- the file should just not exist
* Note compatibility through WP 3.2+
* Call _deprecated_function() within if_file_exists() to generate proper notice/warning
* Minor code formatting changes (spacing)
* Update copyright date (2011)
* Add plugin homepage and author links in description in readme.txt

= 2.0 =
* Rename function from if_file_exists() to c2c_if_file_exists()
* Deprecate if_file_exists, but continue to support it for backwards compatibility
* Add c2c_if_plugin_file_exists()
* Add c2c_if_theme_file_exists()
* Add additional optional argument of $show_if_not_exists to indicate text to show if no file exists (when $format is also specified)
* Add new recognized format tag %file_directory%
* Add new recognized format tag %file_extension%
* Add hook 'c2c_if_file_exists' (filter), 'c2c_if_plugin_file_exists' (filter), and 'c2c_if_theme_file_exists' (filter) to respond to the function of the same name so that users can use the apply_filters() notation for invoking template tag
* Handle error when checking a non-existent path
* Handle being sent empty string as filename
* Check for possible existence of functions before defining them
* Trim $dir argument of whitespace and forward slashes
* Minor reformatting (spacing)
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Remove trailing whitespace in header docs
* Note compatibility with WP 3.0+
* Drop compatibility with versions of WP older than 2.7
* Fix typo in example code
* Add Filters and Upgrade Notice sections to readme.txt

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


== Upgrade Notice ==

= 2.2.1 =
Trivial update: noted compatibility through WP 4.0+; added plugin icon.

= 2.2 =
Recommended minor update: fixed a few minor bugs; added unit tests; noted compatibility through WP 3.8+

= 2.1.3 =
Trivial update: noted compatibility through WP 3.5+; minor documentation changes

= 2.1.2 =
Trivial update: noted compatibility through WP 3.4+; explicitly stated license

= 2.1.1 =
Trivial update: noted compatibility through WP 3.3+ and minor readme.txt tweaks

= 2.1 =
Recommended minor update. Highlights: fixed a few minor bugs, added tests, clarified/updated some documentation, and verified compatibility with WordPress 3.2.

= 2.0 =
Recommended feature update. Highlights: added c2c_if_plugin_file_exists() and c2c_if_theme_file_exists(); added %file_directory% and %file_extension%; added hooks for customization; minor fixes and tweaks; renamed blog_time() to c2c_blog_time(); renamed class; verified WP 3.0 compatibility.
