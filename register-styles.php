<?php

/**
 * Enqueue block styles conditionally.
 * 
 * This function checks if a specific block is in use and, if it is, 
 * enqueues the corresponding stylesheet.
 * 
 * @return void
 */
function jeco_enqueue_conditional_block_styles()
{
  if (has_block('acf/hello-world')) {
    wp_enqueue_style('hello-world-block', plugin_dir_url(__FILE__) . 'blocks/hello-world/style.css');
  }

  if (has_block('acf/jeco-yva-footer')) {
    wp_enqueue_style('jeco-yva-footer-block', plugin_dir_url(__FILE__) . 'blocks/jeco-yva-footer/style.css');
  }
}
add_action('wp_enqueue_scripts', 'jeco_enqueue_conditional_block_styles');