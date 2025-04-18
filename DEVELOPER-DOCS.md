# Developer Documentation

This plugin provides [hooks](#hooks) and [template tags](#template-tags).

## Template Tags

The plugin provides three template tags for use in your theme templates, functions.php, or plugins.

### Functions:

* `<?php function c2c_if_file_exists($filename, $format = '', $echo = true, $dir = '') ?>`
Checks if a file exists and returns true/false or displays a string containing information about the file.
* `<?php function c2c_if_plugin_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) ?>`
Checks if a file exists (relative to the plugins directory) and returns true/false or displays a string containing information about the file.
* `<?php function c2c_if_theme_file_exists( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) ?>`
Checks if a file exists (relative to the current theme's directory) and returns true/false or displays a string containing information about the file. If the current theme is a child theme, then the function will check if the file exists first in the child theme's directory, and if not there, then it will check the parent theme's directory.

### Arguments:

* `$filename` _(string)_
Required. Name of the filename whose existence is being checked. Do not include path information.

* `$format` _(string)_
Optional. Text to be displayed or returned when $filename exists. Leave blank to return true or false. The following percent-tag substitutions are available for optional use in the $format string:
    * `%file_directory%` : the directory of the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/"
    * `%file_extension%` : the extension of the file, i.e. "zip"`
    * `%file_name%` : the name of the file, i.e. "pictures.zip"
    * `%file_size%` : the size of the file, in number of bytes to the largest unit the bytes will fit into, rounded to 2 decimal places, i.e. "1.24 MB"
    * `%file_size_bytes%` : the size of the file, in bytes
    * `%file_url%` : the URL of the file, i.e. "http://yoursite.com/wp-content/uploads/pictures.zip"
    * `%file_path%`: the filesystem path to the file, i.e. "/usr/local/www/yoursite/wp-content/uploads/pictures.zip"

* `$echo` _(bool)_
Optional. Should `$format` be echoed when the filename exists? NOTE: the string always gets returned unless file does not exist). Default is true.

* `$dir` _(string|bool)_
Optional. The directory (relative to the root of the site) to check for $filename. If empty, the WordPress upload directory is assumed (if using `c2c_if_file_exists()`). If 'true', then it indicates the filename includes the directory.

* `$show_if_not_exists` _(string)_
Optional. Text to display if the file does not exists. $format must also be specified. Format is the same as $format argument.

### Examples:

* Output the markup for a link to a particular .zip file if it exists for the current post.

```php
<?php
$format = "<a href='%file_url%'>Download %file_name% now!</a>";
$file_name = 'pictures-' . get_the_ID() . '.zip';
c2c_if_file_exists( $file_name, $format );
?>
```

* Only execute code if a file exists.

```php
<?php
if ( c2c_if_file_exists( $file_name ) ) {
   // Do stuff here
}
?>
```

* `<?php c2c_if_file_exists($file_name, '%file_name% exists!'); ?>`

* `<?php c2c_if_file_exists($file_name, '%file_name% also exists in upload2 directory', true, 'wp-content/uploads2'); ?>`

* `<?php c2c_if_file_exists($file_name, '%file_name% also exists in upload2 directory', true, 'wp-content/uploads2', '%file_name% did not exist!'); ?>`

* `<?php c2c_if_plugin_file_exists('akismet.php', 'Akismet is present', true, 'akismet'); ?>`

* `<?php c2c_if_plugin_file_exists('akismet/akismet.php', 'Akismet is present', true, true); ?>`

* `<?php c2c_if_theme_file_exists('home.php', 'Home template is present', true, '', 'Home template does not exist.'); ?>`


## Hooks

The plugin exposes a number of filters for hooking. Code using these filters should ideally be put into a mu-plugin or site-specific plugin (which is beyond the scope of this readme to explain).

### `c2c_if_file_exists` _(filter)_

The `c2c_if_file_exists` hook allows you to use an alternative approach to safely invoke `c2c_if_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

#### Arguments:

* same as for `c2c_if_file_exists()`

#### Example:

Instead of:

`<?php c2c_if_file_exists( $file, '%file_url%' ); ?>`

Do:

`<?php apply_filters( 'c2c_if_file_exists', $file, '%file_url%' ); ?>`


### `c2c_if_plugin_file_exists`_(filter)_

The `c2c_if_plugin_file_exists` hook allows you to use an alternative approach to safely invoke `c2c_if_plugin_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

#### Arguments:

* same as for `c2c_if_plugin_file_exists()`

#### Example:

Instead of:

`<?php $exists = c2c_if_plugin_file_exists( $file ); ?>`

Do:

`<?php $exists = apply_filters( 'c2c_if_plugin_file_exists', $file ); ?>`


### `c2c_if_theme_file_exists` _(filter)_

The `c2c_if_theme_file_exists` hook allows you to use an alternative approach to safely invoke `c2c_if_theme_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

#### Arguments:

* same as for `c2c_if_theme_file_exists()`

#### Example:

Instead of:

`<?php $exists = c2c_if_theme_file_exists( $file ); ?>`

Do:

`<?php $exists = apply_filters( 'c2c_if_theme_file_exists', $file ); ?>`
