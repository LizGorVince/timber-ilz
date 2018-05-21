<?php

/**
 * The template for displaying the Home page.
 * Template Name: Home
 */

$context = Timber::get_context();
$context['post'] = new Timber\Post();

Timber::render( 'templates/front-page.twig', $context);
