# Changelog

## _(in-progress)_
* New: Add DEVELOPER-DOCS.md and move template tags and hooks documentation into it
* Change: Note compatibility through WP 5.8+
* Change: Tweak installation instruction
* Unit tests:
    * Change: Restructure unit test directories
        * Change: Move `phpunit/` into `tests/`
        * Change: Move `phpunit/bin` into `tests/`
    * Change: Remove 'test-' prefix from unit test file
    * Change: In bootstrap, store path to plugin file constant
    * Change: In bootstrap, add backcompat for PHPUnit pre-v6.0

## 2.2.10 _(2021-04-14)_
* Change: Note compatibility through WP 5.7+
* Change: Update copyright date (2021)

## 2.2.9 _(2020-09-02)_
* New: Add TODO.md for newly added potential TODO items
* Change: Restructure unit test file structure
    * New: Create new subdirectory `phpunit/` to house all files related to unit testing
    * Change: Move `bin/` to `phpunit/bin/`
    * Change: Move `tests/bootstrap.php` to `phpunit/`
    * Change: Move `tests/` to `phpunit/tests/`
    * Change: Rename `phpunit.xml` to `phpunit.xml.dist` per best practices
* Change: Note compatibility through WP 5.5+

## 2.2.8 _(2020-04-30)_
* Fix: Use full path to CHANGELOG.md in the Changelog section of readme.txt
* Change: Use HTTPS for link to WP SVN repository in bin script for configuring unit tests
* Change: Note compatibility through WP 5.4+
* Change: Update links to coffee2code.com to be HTTPS
* Change: Use backticks to denote code in readme.txt

## 2.2.7 _(2019-11-22)_
* Change: Note compatibility through WP 5.3+
* Change: Update copyright date (2020)

## 2.2.6 _(2019-02-11)_
* New: Add CHANGELOG.md and move all but most recent changelog entries into it
* Change: Note compatibility through WP 5.1+
* Change: Update unit test install script and bootstrap to use latest WP unit test repo
* Change: Reformat function docblocks for better line-wrapping and alignment
* Change: Update copyright date (2019)
* Change: Update License URI to be HTTPS
* Change: Split paragraph in README.md's "Support" section into two

## 2.2.5 _(2018-05-22)_
* New: Add README.md
* New: Add GitHub link to readme
* Change: Minor whitespace tweaks to unit test bootstrap
* Change: Rename readme.txt section from 'Filters' to 'Hooks'
* Change: Modify formatting of hook name in readme to prevent being uppercased when shown in the Plugin Directory
* Change: Note compatibility through WP 4.9+
* Change: Update copyright date (2018)

## 2.2.4 _(2017-02-16)_
* Fix: Fix a few unit tests
* Change: Update unit test bootstrap
    * Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable
    * Enable more error output for unit tests
* Change: Note compatibility through WP 4.7+
* Change: Minor readme.txt content and formatting tweaks
* Change: Update copyright date (2017)
* New: Add LICENSE file

## 2.2.3 _(2016-01-18)_
* New: Add support for language packs:
    * Define 'Text Domain' header attribute.
    * Load textdomain.
* New: Create empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).

## 2.2.2 _(2015-02-13)_
* Note compatibility through WP 4.1+
* Update copyright date (2015)

## 2.2.1 _(2014-08-31)_
* Minor plugin header reformatting
* Minor code reformatting (spacing, bracing)
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

## 2.2 _(2013-12-29)_
* Fix to set `$dir` to directory when passed as part of filename and not via $dir arg
* Fix in `c2c_if_plugin_file_exists()` to ensure files are relative to `WP_PLUGIN_DIR`
* Fix to use `add_filter()` instead of `apply_filters()` to enable filter invocation technique
* Convert existing makeshift unit tests to PHPUnit unit tests
* Remove `c2c_test_if_file_exists()`
* Use `site_url()` to get site URL instead of the option
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Minor readme.txt tweaks
* Change donate link
* Add banner

## 2.1.3
* Add check to prevent execution of code if file is directly accessed
* Minor changes to extended description
* Minor code reformatting (spacing)
* Note compatibility through WP 3.5+
* Update copyright date (2013)

## 2.1.2
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

## 2.1.1
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

## 2.1
* Minor bugfix to prevent PHP warning when a file has no extension
* Fix all functions to properly handle boolean $dir argument
* Add `c2c_test_if_file_exists()` to perform some (15) simple tests on the provided functions
* Disable unnecessarily outputting error message when default upload directory is not present -- the file should just not exist
* Note compatibility through WP 3.2+
* Call `_deprecated_function()` within `if_file_exists()` to generate proper notice/warning
* Minor code formatting changes (spacing)
* Update copyright date (2011)
* Add plugin homepage and author links in description in readme.txt

## 2.0
* Rename function from `if_file_exists()` to `c2c_if_file_exists()`
* Deprecate `if_file_exists()`, but continue to support it for backwards compatibility
* Add `c2c_if_plugin_file_exists()`
* Add `c2c_if_theme_file_exists()`
* Add additional optional argument of $show_if_not_exists to indicate text to show if no file exists (when $format is also specified)
* Add new recognized format tag `%file_directory%`
* Add new recognized format tag `%file_extension%`
* Add hook `c2c_if_file_exists` (filter), `c2c_if_plugin_file_exists` (filter), and `c2c_if_theme_file_exists` (filter) to respond to the function of the same name so that users can use the `apply_filters()` notation for invoking template tag
* Handle error when checking a non-existent path
* Handle being sent empty string as filename
* Check for possible existence of functions before defining them
* Trim `$dir` argument of whitespace and forward slashes
* Minor reformatting (spacing)
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Remove trailing whitespace in header docs
* Note compatibility with WP 3.0+
* Drop compatibility with versions of WP older than 2.7
* Fix typo in example code
* Add Filters and Upgrade Notice sections to readme.txt

## 1.0.3
* Add PHPDoc documentation
* Change description and update documentation
* Minor formatting tweaks
* Note compatibility with WP 2.9+
* Update copyright date
* Update readme.txt (including adding Changelog)

## 1.0.2
* Note compatibility with WP 2.8+

## 1.0.1
* Note compatibility with WP 2.6+, 2.7+

## 1.0
* Initial release
