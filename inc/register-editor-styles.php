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

}
add_action('enqueue_block_editor_assets', 'jeco_enqueue_block_editor_styles');
