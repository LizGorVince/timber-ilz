<?php

// Wordpress default category template

$context = Timber::get_context();
$post = new TimberPost();

Timber::render( array( 'templates/category.twig', 'templates/archive.twig' ), $context );
