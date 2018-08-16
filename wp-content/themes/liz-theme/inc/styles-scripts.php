<?php

// Enqueue scripts and styles
function gv_enqueue() {

  // Serve unminified CSS if on a local domain
  $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($url, "local.")!==false) {
    wp_enqueue_style( 'css-main', get_template_directory_uri() . '/assets/dist/css/main.css', array(), filemtime( get_stylesheet_directory() . '/assets/dist/css/main.css' ) );
  }
  else {
    wp_enqueue_style( 'css-main-min', get_template_directory_uri() . '/assets/dist/css/main.min.css', array(), filemtime( get_stylesheet_directory() . '/assets/dist/css/main.min.css' ) );
  }

  wp_enqueue_style( 'liz-googlefonts', '//fonts.googleapis.com/css?family=Arvo', true );
  wp_enqueue_style( 'liz-googlefonts2', '//fonts.googleapis.com/css?family=Josefin+Sans', true );
  wp_enqueue_style( 'liz-fontawesome', '//use.fontawesome.com/releases/v5.2.0/css/all.css', true);
  wp_enqueue_script( 'js-jquery', get_template_directory_uri() . '/assets/src/js/jquery-3.3.1.min.js', array(), true );
  wp_enqueue_script( 'js-scripts', get_template_directory_uri() . '/assets/dist/js/script.js', array(), true );
}

add_action( 'wp_enqueue_scripts', 'gv_enqueue' );

// Move Javascript files to footer
function remove_head_scripts() {
  remove_action('wp_head', 'wp_print_scripts');
  remove_action('wp_head', 'wp_print_head_scripts', 9);
  remove_action('wp_head', 'wp_enqueue_scripts', 1);
  add_action('wp_footer', 'wp_print_scripts', 5);
  add_action('wp_footer', 'wp_enqueue_scripts', 5);
  add_action('wp_footer', 'wp_print_head_scripts', 5);
}

add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );
