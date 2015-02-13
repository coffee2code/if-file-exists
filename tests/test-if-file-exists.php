<?php

class Reveal_Template_Test extends WP_UnitTestCase {

	/**
	 *
	 * HELPER FUNCTIONS
	 *
	 */


	function get_echo_output( $filename, $format = '', $echo = true, $dir = '', $show_if_not_exists = '' ) {
		ob_start();
		c2c_if_file_exists( $filename, $format, $echo, $dir, $show_if_not_exists );
		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}


	/**
	 *
	 * TESTS
	 *
	 */


	function test_detects_nonexistent_file_with_relative_path() {
		$this->assertFalse( c2c_if_file_exists( 'nonexistent.txt' ) );
	}

	function test_detects_nonexistent_file_with_full_path() {
		$this->assertFalse( c2c_if_file_exists( ABSPATH . 'nonexistent.txt', '', false, true ) );
	}

	function test_detects_nonexistent_file_with_dir_arg() {
		$this->assertFalse( c2c_if_file_exists( 'nonexistent.txt', '', false, ABSPATH ) );
	}

	function test_detects_nonexistent_file_with_false_dir_arg() {
		$this->assertFalse( c2c_if_file_exists( 'nonexistent.txt', '', false, false ) );
	}

	// In order to test these, we'd have to know an existing file in default wp_uploads directory
	/*
	function test_detects_existing_file_with_relative_path() {
		$this->assertTrue( c2c_if_file_exists( 'existing.txt' );
	}

	function test_detects_existing_file_with_false_dir_arg() {
		$this->assertTrue( c2c_if_file_exists( 'existing.txt', '', false, false ) );
	}
	*/

	function test_detects_existing_file_with_full_path() {
		$this->assertTrue( c2c_if_file_exists( ABSPATH . 'wp-includes/version.php', '', false, true ) );
	}

	function test_detects_existing_file_with_dir_arg() {
		$this->assertTrue( c2c_if_file_exists( 'version.php', '', false, ABSPATH . 'wp-includes' ) );
	}

	function test_format_string_for_nonexistent_file() {
		$f = 'nonexistent.txt';

		$this->assertEmpty( c2c_if_file_exists( $f, '%file_name%' ) );
		$this->assertEmpty( c2c_if_file_exists( $f, '%file_directory%' ) );
		$this->assertEmpty( c2c_if_file_exists( $f, '%file_extension%' ) );
		$this->assertEmpty( c2c_if_file_exists( $f, '%file_path%' ) );
		$this->assertEmpty( c2c_if_file_exists( $f, '%file_url%' ) );
		$this->assertEmpty( c2c_if_file_exists( $f, 'file exists', true ) );
	}

	function test_format_string_for_existing_file_with_full_path() {
		$f = ABSPATH . 'wp-includes/version.php';
		$parts = pathinfo( $f );

		$this->assertEquals( basename( $f ), c2c_if_file_exists( $f, '%file_name%', false, true ) );
		$this->assertEquals( dirname( $f ), c2c_if_file_exists( $f, '%file_directory%', false, true ) );
		$this->assertEquals( $parts['extension'], c2c_if_file_exists( $f, '%file_extension%', false, true ) );
		$this->assertEquals( $f, c2c_if_file_exists( $f, '%file_path%', false, true ) );
		$this->assertEquals( includes_url( 'version.php' ), c2c_if_file_exists( $f, '%file_url%', false, true ) );
		$this->assertEquals( 'file exists', c2c_if_file_exists( $f, 'file exists', false, true ) );
	}

	function test_format_string_for_existing_file_with_dir_arg() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$f = ABSPATH . 'wp-includes/version.php';
		$parts = pathinfo( $f );

		$this->assertEquals( $filename, c2c_if_file_exists( $filename, '%file_name%', false, $dir ) );
		$this->assertEquals( dirname( $f ), c2c_if_file_exists( $filename, '%file_directory%', false, $dir ) );
		$this->assertEquals( $parts['extension'], c2c_if_file_exists( $filename, '%file_extension%', false, $dir ) );
		$this->assertEquals( $f, c2c_if_file_exists( $filename, '%file_path%', false, $dir ) );
		$this->assertEquals( includes_url( 'version.php' ), c2c_if_file_exists( $filename, '%file_url%', false, $dir ) );
		$this->assertEquals( 'file exists', c2c_if_file_exists( $filename, 'file exists', false, $dir ) );
	}

	function test_show_if_not_exists_for_nonexistent_file() {
		$msg = 'file does not exist';

		$this->assertEquals( $msg, c2c_if_file_exists( 'nonexistent.php', '%file_name%', false, $dir, $msg ) );
	}

	function test_show_if_not_exists_for_existing_file() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$f = ABSPATH . 'wp-includes/version.php';

		$this->assertEquals( $filename, c2c_if_file_exists( $filename, '%file_name%', false, $dir, 'file does not exist' ) );
	}

	function test_echo_for_nonexistent_file() {
		$f = 'nonexistent.txt';

		$this->assertEmpty( $this->get_echo_output( $f, '%file_name%', true ) );
		$this->assertEmpty( $this->get_echo_output( $f, '%file_directory%', true ) );
		$this->assertEmpty( $this->get_echo_output( $f, '%file_extension%', true ) );
		$this->assertEmpty( $this->get_echo_output( $f, '%file_path%', true ) );
		$this->assertEmpty( $this->get_echo_output( $f, '%file_url%', true ) );
		$this->assertEmpty( $this->get_echo_output( $f, 'file exists', true ) );
	}

	function test_echo_for_existing_file() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$f = ABSPATH . 'wp-includes/version.php';
		$parts = pathinfo( $f );

		$this->assertEquals( $filename, $this->get_echo_output( $filename, '%file_name%', true, $dir ) );
		$this->assertEquals( dirname( $f ), $this->get_echo_output( $filename, '%file_directory%', true, $dir ) );
		$this->assertEquals( $parts['extension'], $this->get_echo_output( $filename, '%file_extension%', true, $dir ) );
		$this->assertEquals( $f, $this->get_echo_output( $filename, '%file_path%', true, $dir ) );
		$this->assertEquals( includes_url( 'version.php' ), $this->get_echo_output( $filename, '%file_url%', true, $dir ) );
		$this->assertEquals( 'file exists', $this->get_echo_output( $filename, 'file exists', true, $dir ) );
	}

	function test_if_plugin_file_exists_with_nonexistent_file() {
		$this->assertFalse( c2c_if_plugin_file_exists( 'nonexistent.txt' ) );
	}

	function test_if_plugin_file_exists_with_existing_file() {
		$this->assertTrue( c2c_if_plugin_file_exists( 'hello.php' ) );
	}

	function test_if_theme_file_exists_with_nonexistent_file() {
		$this->assertFalse( c2c_if_theme_file_exists( 'nonexistent.txt' ) );
	}

	function test_if_theme_file_exists_with_existing_file() {
		$this->assertTrue( c2c_if_theme_file_exists( 'style.css' ) );
		// TODO: Be smarter about this and find an actual file in a theme subdirectory.
		$this->assertTrue( c2c_if_theme_file_exists( 'ie.css', '', false, 'css' ) );
	}

	function test_filter_invocation_of_if_file_exists() {
		$this->assertFalse( apply_filters( 'c2c_if_file_exists', 'nonexistent.txt' ) );
		$this->assertEquals( 'version.php', apply_filters( 'c2c_if_file_exists', 'version.php', '%file_name%', false, ABSPATH . 'wp-includes' ) );
	}

	function test_filter_invocation_of_if_plugin_file_exists() {
		$this->assertFalse( apply_filters( 'c2c_if_plugin_file_exists', 'nonexistent.txt' ) );
		$this->assertEquals( 'hello.php', apply_filters( 'c2c_if_plugin_file_exists', 'hello.php', '%file_name%', false ) );
	}

	function test_filter_invocation_of_if_theme_file_exists() {
		$this->assertFalse( apply_filters( 'c2c_if_theme_file_exists', 'nonexistent.txt' ) );
		// TODO: Be smarter about this and find an actual file in a theme subdirectory.
		$this->assertEquals( 'ie.css', apply_filters( 'c2c_if_theme_file_exists', 'ie.css', '%file_name%', false, 'css' ) );
	}

}
