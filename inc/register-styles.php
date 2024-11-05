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

// Registering the jeco-related-posts styles
if (has_block('acf/jeco-related-posts')) {
    wp_enqueue_style(
      'jeco-related-posts-block',
      JECO_BLOCKS_ROOT_URL . 'blocks/jeco-related-posts/style.css',
      array()
    );
}

}
add_action('wp_enqueue_scripts', 'jeco_enqueue_conditional_block_styles');
