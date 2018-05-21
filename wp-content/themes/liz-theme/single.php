<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['cat'] = new TimberTerm();
$categories = $post->terms( 'category' );

// Get only the first category from the array
$context['category'] = reset( $categories );

// List most the 5 most recent blog posts
$recent_posts = array(
  'post_type'       => 'post',
  'order'           => '',
  'posts_per_page'  => 5
);

$context['recent_posts'] = Timber::get_posts( $recent_posts );

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'templates/single-password.twig', $context );
} else {
	Timber::render( array( 'templates/single-' . $post->ID . '.twig', 'templates/single-' . $post->post_type . '.twig', 'templates/single.twig' ), $context );
}
