<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

Timber::$dirname = array('templates', 'views');

class rtopFunctions extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_options' ) );
		add_action( 'init', array( $this, 'styles_scripts' ) );
		parent::__construct();
	}

	function register_menus() {
		require('inc/register-menus.php');
	}

	function register_options() {
		require('inc/register-options.php');
	}

	function styles_scripts() {
		require('inc/styles-scripts.php');
  }

	function add_to_context( $context ) {

		// Set WP menus as context variables
		$context['main_nav'] = new TimberMenu('main_nav');
		$context['footer_nav'] = new TimberMenu('footer_nav');

		// Set ACF options section as context variable
    $context['options'] = get_fields('option');

		// Set up an archive object with date info for all posts
		$archive_args = array(
		  'post_type' => 'post'
		);
		$context['archives'] = new TimberArchives( $archive_args );

		// Set up an categories object with all non-empty categories
		$categories_args = get_categories( array(
			'orderby' => 'name',
			'order'   => 'ASC',
			'hide_empty' => '1'
		) );
		$context['categories'] = $categories_args;

		return $context;
	}

	function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}
}

new rtopFunctions();

// Other function files
require get_template_directory() . '/inc/emoji.php';
