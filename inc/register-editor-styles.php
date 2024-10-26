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

  // Enqueue styles for the editor for yva-footer
  if (has_block('acf/yva-footer')) {
    wp_enqueue_style(
      'yva-footer-editor-style',
      JECO_BLOCKS_ROOT_URL . 'blocks/yva-footer/editor-style.css',
      array()
    );
  }
  // Enqueue styles for the editor for yva-social-icons-banner
  if (has_block('acf/yva-social-icons-banner')) {
    wp_enqueue_style(
      'yva-social-icons-banner-editor-style',
      JECO_BLOCKS_ROOT_URL . 'blocks/yva-social-icons-banner/editor-style.css',
      array()
    );
  }
}
add_action('enqueue_block_editor_assets', 'jeco_enqueue_block_editor_styles');
