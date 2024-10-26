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

// Registering the yva-footer styles
if (has_block('acf/yva-footer')) {
    wp_enqueue_style(
      'yva-footer-block',
      JECO_BLOCKS_ROOT_URL . 'blocks/yva-footer/style.css',
      array()
    );
}

// Registering the yva-social-icons-banner styles
if (has_block('acf/yva-social-icons-banner')) {
    wp_enqueue_style(
      'yva-social-icons-banner-block',
      JECO_BLOCKS_ROOT_URL . 'blocks/yva-social-icons-banner/style.css',
      array(),
    );
}

}
add_action('wp_enqueue_scripts', 'jeco_enqueue_conditional_block_styles');
