=== If File Exists ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: file, exists, existence, filesystem, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 2.7
Tested up to: 6.6
Stable tag: 2.3.2

Check if a file exists and return true/false or display a string containing information about the file.


== Description ==

This plugin provides the functions `c2c_if_file_exists()`, `c2c_if_theme_file_exists()`, `c2c_if_plugin_file_exists()` that check if a file exists and either return true/false or display a string containing information about the file.

* If a format string is not passed to it, the functions return a simple boolean (true or false) indicating if the specified file exists.
* Otherwise, the format string provided to it will be used to construct a response string, which can be customized to display information about the file (such as file_name, file_url, or file_path). If the `$echo` argument is true, that string is displayed on the page. Regardless of the value of `$echo`, the response string is returned by the function.

By default, `c2c_if_file_exists()` assumes you are looking for the file relative to the default WordPress upload directory. If you wish to search another directory, specify it as the `$dir` argument. `c2c_if_theme_file_exists()` assumes you are looking for a file relative to the currently active theme's home directory. `c2c_if_plugin_file_exists()` assumes you are looking for a file relative to the directory that contains WordPress plugins.

Links: [Plugin Homepage](https://coffee2code.com/wp-plugins/if-file-exists/) | [Plugin Directory Page](https://wordpress.org/plugins/if-file-exists/) | [GitHub](https://github.com/coffee2code/if-file-exists/) | [Author Homepage](https://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or install the plugin code inside the plugins directory for your site (typically `/wp-content/plugins/`).
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. In one or more of your templates, utilize one of the template tags provided by this plugin (see examples)


== Developer Documentation ==

Developer documentation can be found in [DEVELOPER-DOCS.md](https://github.com/coffee2code/if-file-exists/blob/master/DEVELOPER-DOCS.md). That documentation covers the template tags and hooks provided by the plugin.

As an overview, these are the template tags provided by the plugin:

* `c2c_if_file_exists()`        : Checks if a file exists and returns true/false or displays a string containing information about the file.
* `c2c_if_plugin_file_exists()` : Checks if a file exists (relative to the plugins directory) and returns true/false or displays a string containing information about the file.
* `c2c_if_theme_file_exists()`  : Checks if a file exists (relative to the current theme's directory) and returns true/false or displays a string containing information about the file. If the current theme is a child theme, then the function will check if the file exists first in the child theme's directory, and if not there, then it will check the parent theme's directory.

Theses are the hooks provided by the plugin:

* `c2c_if_file_exists`        : Filter that allows use of an alternative approach to safely invoke `c2c_if_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.
* `c2c_if_plugin_file_exists` : Filter that allows use of an alternative approach to safely invoke `c2c_if_plugin_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.
* `c2c_if_theme_file_exists`  : Filter that allows use of an alternative approach to safely invoke `c2c_if_theme_file_exists()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.


== Changelog ==

= 2.3.2 (2024-08-02) =
* Change: Note compatibility through WP 6.6+
* Change: Update copyright date (2024)
* New: Add `.gitignore` file
* Change: Remove development and testing-related files from release packaging
* Unit tests:
    * Hardening: Prevent direct web access to `bootstrap.php`
    * Allow tests to run against current versions of WordPress
    * New: Add `composer.json` for PHPUnit Polyfill dependency
    * Change: In bootstrap, store path to plugin directory in a constant

= 2.3.1 (2023-05-18) =
* Change: Note compatibility through WP 6.3+
* Change: Update copyright date (2023)
* New: Add a potential TODO item

= 2.3 (2021-10-09) =
Highlights:

This minor release removes support for the long-deprecated `if_file_exists()`, adds DEVELOPER-DOCS.md, notes compatibility through WP 5.8+, and minor reorganization and tweaks to unit tests.

Details:

* Change: Remove support for long-deprecated `if_file_exists()`
* New: Add DEVELOPER-DOCS.md and move template tags and hooks documentation into it
* Change: Note compatibility through WP 5.8+
* Change: Tweak installation instruction
* Change: Pare down tags in readme.txt header
* Unit tests:
    * New: Add dataProvider `get_file_formatting_placeholders()` and use it instead of explicitly listing assertions for each placeholder
    * Change: Restructure unit test directories
        * Change: Move `phpunit/` into `tests/`
        * Change: Move `phpunit/bin` into `tests/`
    * Change: Remove 'test-' prefix from unit test file
    * Change: Remove `get_echo_output()` and replaces its use with built-in `expectOutputRegex()`
    * Change: In bootstrap, store path to plugin file constant
    * Change: In bootstrap, add backcompat for PHPUnit pre-v6.0

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/if-file-exists/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 2.3.2 =
Trivial update: noted compatibility through WP 6.6+, removed unit tests from release packaging, and updated copyright date (2024)

= 2.3.1 =
Trivial update: noted compatibility through WP 6.3+ and updated copyright date (2023)

= 2.3 =
Minor update: removed support for long-deprecated `if_file_exists()`, added DEVELOPER-DOCS.md, noted compatibility through WP 5.8+, and minor reorganization and tweaks to unit tests

= 2.2.10 =
Trivial update: noted compatibility through WP 5.7+ and updated copyright date (2021)

= 2.2.9 =
Trivial update: Restructured unit test file structure and noted compatibility through WP 5.5+.

= 2.2.8 =
Trivial update: Fixed a link in readme.txt, updated a few URLs to be HTTPS and noted compatibility through WP 5.4+.

= 2.2.7 =
Trivial update: noted compatibility through WP 5.3+ and updated copyright date (2020).

= 2.2.6 =
Trivial update: created CHANGELOG.md to store historical changelog outside of readme.txt, noted compatibility through WP 5.1+, and updated copyright date (2019)

= 2.2.5 =
Trivial update: noted compatibility through WP 4.9+, added README.md for GitHub, updated copyright date (2018), and other minor changes

= 2.2.4 =
Trivial update: fixed some unit tests, noted compatibility through WP 4.7+, updated copyright date

= 2.2.3 =
Trivial update: improved support for localization, minor unit test tweaks, verified compatibility through WP 4.4+, and updated copyright date (2016)

= 2.2.2 =
Trivial update: noted compatibility through WP 4.1+ and updated copyright date (2015)

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
