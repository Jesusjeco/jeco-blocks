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
    // Register the hello-world block
    acf_register_block_type([
      'name'              => 'hello-world',
      'title'             => __('Hello World'),
      'description'       => __('A custom block for displaying a Hello World message.'),
      'render_template'   => plugin_dir_path(__FILE__) . 'blocks/hello-world/render.php',
      'category'          => 'formatting',
      'icon'              => 'admin-site-alt3',
      'keywords'          => array('hello', 'world'),
      'supports'          => array(
        'align' => true,
      ),
    ]);

  } else {
    error_log('ACF function acf_register_block_type does not exist.');
  }
}
// Hook into the ACF init action to register the block
add_action('acf/init', 'jeco_register_acf_blocks');
