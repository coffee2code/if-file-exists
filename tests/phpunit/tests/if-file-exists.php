<?php

defined( 'ABSPATH' ) or die();

class If_File_Exists_Test extends WP_UnitTestCase {

	//
	//
	// HELPER FUNCTIONS
	//
	//


	public function get_file_formatting_placeholders() {
		return array(
			array( '%file_name%' ),
			array( '%file_directory%' ),
			array( '%file_extension%' ),
			array( '%file_path%' ),
			array( '%file_size%' ),
			array( '%file_size_bytes%' ),
			array( '%file_url%' ),
			array( 'file exists' ),
		);
	}


	//
	//
	// TESTS
	//
	//


	public function test_detects_nonexistent_file_with_relative_path() {
		$this->assertFalse( c2c_if_file_exists( 'nonexistent.txt' ) );
	}

	public function test_detects_nonexistent_file_with_full_path() {
		$this->assertFalse( c2c_if_file_exists( ABSPATH . 'nonexistent.txt', '', false, true ) );
	}

	public function test_detects_nonexistent_file_with_dir_arg() {
		$this->assertFalse( c2c_if_file_exists( 'nonexistent.txt', '', false, ABSPATH ) );
	}

	public function test_detects_nonexistent_file_with_false_dir_arg() {
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

	public function test_detects_existing_file_with_full_path() {
		$this->assertTrue( c2c_if_file_exists( ABSPATH . 'wp-includes/version.php', '', false, true ) );
	}

	public function test_detects_existing_file_with_dir_arg() {
		$this->assertTrue( c2c_if_file_exists( 'version.php', '', false, ABSPATH . 'wp-includes' ) );
	}

	/**
	 * @dataProvider get_file_formatting_placeholders
	 */
	public function test_format_string_for_nonexistent_file( $placeholder ) {
		$f = 'nonexistent.txt';

		$this->assertEmpty( c2c_if_file_exists( $f, $placeholder ) );
	}

	public function test_format_string_for_existing_file_with_full_path() {
		$f = ABSPATH . 'wp-includes/version.php';
		$parts = pathinfo( $f );

		$this->assertEquals( basename( $f ), c2c_if_file_exists( $f, '%file_name%', false, true ) );
		$this->assertEquals( dirname( $f ), c2c_if_file_exists( $f, '%file_directory%', false, true ) );
		$this->assertEquals( $parts['extension'], c2c_if_file_exists( $f, '%file_extension%', false, true ) );
		$this->assertEquals( $f, c2c_if_file_exists( $f, '%file_path%', false, true ) );
		$this->assertEquals( str_replace( '.00', '', size_format( filesize( $f ), 2 ) ), c2c_if_file_exists( $f, '%file_size%', false, true ) );
		$this->assertEquals( filesize( $f ), c2c_if_file_exists( $f, '%file_size_bytes%', false, true ) );
		$this->assertEquals( includes_url( 'version.php' ), c2c_if_file_exists( $f, '%file_url%', false, true ) );
		$this->assertEquals( 'file exists', c2c_if_file_exists( $f, 'file exists', false, true ) );
	}

	public function test_format_string_for_existing_file_with_dir_arg() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$f = ABSPATH . 'wp-includes/version.php';
		$parts = pathinfo( $f );

		$this->assertEquals( $filename, c2c_if_file_exists( $filename, '%file_name%', false, $dir ) );
		$this->assertEquals( dirname( $f ), c2c_if_file_exists( $filename, '%file_directory%', false, $dir ) );
		$this->assertEquals( $parts['extension'], c2c_if_file_exists( $filename, '%file_extension%', false, $dir ) );
		$this->assertEquals( $f, c2c_if_file_exists( $filename, '%file_path%', false, $dir ) );
		$this->assertEquals( str_replace( '.00', '', size_format( filesize( $f ), 2 ) ), c2c_if_file_exists( $f, '%file_size%', false, true ) );
		$this->assertEquals( filesize( $f ), c2c_if_file_exists( $f, '%file_size_bytes%', false, true ) );
		$this->assertEquals( includes_url( 'version.php' ), c2c_if_file_exists( $filename, '%file_url%', false, $dir ) );
		$this->assertEquals( 'file exists', c2c_if_file_exists( $filename, 'file exists', false, $dir ) );
	}

	public function test_return_value_when_format_string_containss_safe_markup() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$format = '<strong>%file_name%</strong>';
		$expected = str_replace( '%file_name%', $filename, $format );

		$this->assertEquals( $expected, c2c_if_file_exists( $filename, $format, false, $dir ) );
	}

	public function test_return_value_when_format_string_contains_unsafe_markup() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$format = '<strong>%file_name% <script>alert("boom!");</script></strong>';
		$expected = str_replace( '%file_name%', $filename, $format );

		$this->assertEquals( $expected, c2c_if_file_exists( $filename, $format, false, $dir ) );
	}

	public function test_echo_value_when_format_string_containss_safe_markup() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$format = '<strong>%file_name%</strong>';
		$expected = str_replace( '%file_name%', $filename, $format );

		ob_start();
		c2c_if_file_exists( $filename, $format, true, $dir );
		$out = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( $expected, $out );
	}

	public function test_echo_value_when_format_string_contains_unsafe_markup() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$format = '<strong>%file_name% <script>alert("boom!");</script></strong>';
		$expected = '<strong>' . $filename . ' alert("boom!");</strong>';

		ob_start();
		c2c_if_file_exists( $filename, $format, true, $dir );
		$out = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( $expected, $out );
	}

	public function test_show_if_not_exists_for_nonexistent_file() {
		$dir = 'wp-includes';
		$msg = 'file does not exist';

		$this->assertEquals( $msg, c2c_if_file_exists( 'nonexistent.php', '%file_name%', false, $dir, $msg ) );
	}

	public function test_return_value_when_show_if_not_exists_for_nonexistent_file_with_safe_markup() {
		$dir = 'wp-includes';
		$msg = '<strong>file does not exist</strong>';

		$this->assertEquals( $msg, c2c_if_file_exists( 'nonexistent.php', '%file_name%', false, $dir, $msg ) );
	}

	public function test_return_value_when_show_if_not_exists_for_nonexistent_file_with_unsafe_markup() {
		$dir = 'wp-includes';
		$msg = '<strong>file does not exist <script>alert("boom");</script>!</strong>';
		$expected = '<strong>file does not exist alert("boom");!</strong>';

		$this->assertEquals( $msg, c2c_if_file_exists( 'nonexistent.php', '%file_name%', false, $dir, $msg ) );
	}

	public function test_echo_value_when_show_if_not_exists_for_nonexistent_file_with_safe_markup() {
		$dir = 'wp-includes';
		$msg = '<strong>file does not exist</strong>';

		ob_start();
		c2c_if_file_exists( 'nonexistent.php', '%file_name%', true, $dir, $msg );
		$out = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( $msg, $out );
	}

	public function test_echo_value_when_show_if_not_exists_for_nonexistent_file_with_unsafe_markup() {
		$dir = 'wp-includes';
		$msg = '<strong>file does not exist <script>alert("boom");</script>!</strong>';
		$expected = '<strong>file does not exist alert("boom");!</strong>';

		ob_start();
		c2c_if_file_exists( 'nonexistent.php', '%file_name%', true, $dir, $msg );
		$out = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( $expected, $out );
	}

	public function test_show_if_not_exists_for_existing_file() {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$f = ABSPATH . 'wp-includes/version.php';

		$this->assertEquals( $filename, c2c_if_file_exists( $filename, '%file_name%', false, $dir, 'file does not exist' ) );
	}

	/**
	 * @dataProvider get_file_formatting_placeholders
	 */
	public function test_echo_for_nonexistent_file( $placeholder ) {
		$f = 'nonexistent.txt';

		$this->expectOutputRegex( '/^$/', c2c_if_file_exists( $f, $placeholder, true ) );
	}

	/**
	 * @dataProvider get_file_formatting_placeholders
	 */
	public function test_echo_for_existing_file( $placeholder ) {
		$dir = 'wp-includes';
		$filename = 'version.php';
		$f = ABSPATH . 'wp-includes/version.php';
		$parts = pathinfo( $f );

		$expectations = array(
			'%file_name%'      => $filename,
			'%file_directory%' => dirname( $f ),
			'%file_extension%' => $parts['extension'],
			'%file_path%'      => $f,
			'%file_size%'      => str_replace( '.00', '', size_format( filesize( $f ), 2 ) ),
			'%file_size_bytes%'=> filesize( $f ),
			'%file_url%'       => includes_url( 'version.php' ),
			'file exists'      => 'file exists',
		);

		$this->expectOutputRegex( '/' . preg_quote( $expectations[ $placeholder ], '/' ) . '/', c2c_if_file_exists( $filename, $placeholder, true, $dir ) );
	}

	public function test_if_plugin_file_exists_with_nonexistent_file() {
		$this->assertFalse( c2c_if_plugin_file_exists( 'nonexistent.txt' ) );
		$this->assertFalse( c2c_if_theme_file_exists( 'nonexistent.txt', '', false, 'text' ) );
	}

	public function test_if_plugin_file_exists_with_existing_file() {
		$this->assertTrue( c2c_if_plugin_file_exists( 'hello.php' ) );
	}

	public function test_if_theme_file_exists_with_nonexistent_file() {
		$this->assertFalse( c2c_if_theme_file_exists( 'nonexistent.txt' ) );
		$this->assertFalse( c2c_if_theme_file_exists( 'nonexistent.css', '', false, 'css' ) );
	}

	public function test_if_theme_file_exists_with_existing_file() {
		$this->assertTrue( c2c_if_theme_file_exists( 'style.css' ) );
		// TODO: Test finding a file in a subdirectory relative to current theme.
		// (WP unit tests have no such example file to use.)
		//$this->assertTrue( c2c_if_theme_file_exists( 'ie.css', '', false, 'css' ) );
	}

	public function test_filter_invocation_of_if_file_exists() {
		$this->assertFalse( apply_filters( 'c2c_if_file_exists', 'nonexistent.txt' ) );
		$this->assertEquals( 'version.php', apply_filters( 'c2c_if_file_exists', 'version.php', '%file_name%', false, ABSPATH . 'wp-includes' ) );
	}

	public function test_filter_invocation_of_if_plugin_file_exists() {
		$this->assertFalse( apply_filters( 'c2c_if_plugin_file_exists', 'nonexistent.txt' ) );
		$this->assertEquals( 'hello.php', apply_filters( 'c2c_if_plugin_file_exists', 'hello.php', '%file_name%', false ) );
	}

	public function test_filter_invocation_of_if_theme_file_exists() {
		$this->assertFalse( apply_filters( 'c2c_if_theme_file_exists', 'nonexistent.txt' ) );
		// TODO: Test finding a file in a subdirectory relative to current theme.
		// (WP unit tests have no such example file to use.)
		//$this->assertEquals( 'ie.css', apply_filters( 'c2c_if_theme_file_exists', 'ie.css', '%file_name%', false, 'css' ) );
	}

}
