// ON READY
jQuery(document).ready(function($) {

  // IF USING TYPEKIT
  // try{Typekit.load({ async: true });}catch(e){}

  // LOAD CUSTOM JS MODULES
  exampleFunction();
});

// LOADED
$(window).on('load', function() {
  $('html').addClass('js--loaded'); // JS loaded flag
  $('body').removeClass('no-js').addClass('js--loaded');
});
