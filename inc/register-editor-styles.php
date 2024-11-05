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
function jeco_enqueue_block_editor_styles()
{

  // Enqueue styles for the editor for jeco-related-posts
  if (has_block('acf/jeco-related-posts')) {
    wp_enqueue_style(
      'jeco-related-posts-editor-style',
      JECO_BLOCKS_ROOT_URL . 'blocks/jeco-related-posts/editor-style.css',
      array()
    );
  }
}
add_action('enqueue_block_editor_assets', 'jeco_enqueue_block_editor_styles');
