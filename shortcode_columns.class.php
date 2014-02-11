<?php
defined( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: (WCM) Twitter Bootstrap Columns
 * Description: Adds the <code>[column]</code> shortcode. Also adds a new TinyMCE button.
 * Author:      Franz Josef Kaiser <wecodemore@gmail.com>
 * Author URL:  http://unserkaiser.com
 * Plugin URL:  https://github.com/franz-josef-kaiser/shortcode_columns
 * License:     MIT
 * Version:     2013-03-30.1911
 */

register_activation_hook( __FILE__, array( 'TBS_Column', 'on_activation' ) );
add_action( 'plugins_loaded', array( 'TBS_Column', 'init' ) );
class TBS_Column
{
	protected static $instance;

	public $button_name = 'column';

	public static function init()
	{
		null === self::$instance AND self::$instance = new self;
		return self::$instance;
	}

	public function on_activation()
	{
		add_filter( 'tiny_mce_version', array( $this, 'refresh_mce_version' ) );
	}

	public function refresh_mce_version( $version )
	{
		$version += rand( 0, 10 );
		return absint( $version );
	}

	public function __construct()
	{
		add_shortcode( 'column', array( $this, 'shortcode_column' ) );

		add_action( 'load-post.php', array( $this, 'add_tinymce_button' ) );
		add_action( 'load-post-new.php', array( $this, 'add_tinymce_button' ) );
	}

	public function shortcode_column( $atts, $content = null )
	{
		extract( shortcode_atts( array(
			'amount' => 1
		), $atts ) );

		return sprintf(
			'<div class="span%s">%s</div>',
			12 / absint( $amount ),
			do_shortcode( $content )
		);
	}

	public function add_tinymce_button()
	{
		if ( ! get_user_option( 'rich_editing' ) )
			return;

		add_filter( 'mce_external_plugins', array( $this, 'add_new_tinymce_plugin' ) );
		add_filter( 'mce_buttons', array( $this, 'register_new_button' ) );
	}

	public function add_new_tinymce_plugin( $plugins_array )
	{
		$plugins_array[ $this->button_name ] = plugin_dir_url( __FILE__ ).'assets/button.js';
		return $plugins_array;
	}

	public function register_new_button( $buttons )
	{
		$pos = array_search( 'wp_more', $buttons );
		if ( ! is_int( $pos ) )
			return array_unshift(
				$buttons,
				$this->button_name
			);

		$chunks = array_chunk(
			$buttons,
			$pos +1,
			true
		);
		$buttons = array_shift( $chunks );
		array_push(
			$buttons,
			$this->button_name
		);
		foreach ( $chunks as $chunk )
			$buttons = $buttons + $chunk;

		return $buttons;
	}
}