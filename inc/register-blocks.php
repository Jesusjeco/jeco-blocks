<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Registers ACF blocks.
 *
 * This function registers the custom blocks using the ACF `acf_register_block_type` function.
 *
 * @return void
 */
function jeco_register_acf_blocks()
{
  // Check if the function exists to avoid errors
  if (function_exists('acf_register_block_type')) {

  } else {
    error_log('ACF function acf_register_block_type does not exist.');
  }
}
// Hook into the ACF init action to register the block
add_action('acf/init', 'jeco_register_acf_blocks');
