<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

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
    wp_enqueue_style('hello-world-block', JECO_BLOCKS_ROOT_URL . 'blocks/hello-world/style.css');
  }
}
add_action('wp_enqueue_scripts', 'jeco_enqueue_conditional_block_styles');
