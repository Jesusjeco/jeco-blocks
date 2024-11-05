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

        // Register the jeco-related-posts block
        acf_register_block_type([
            'name'              => 'jeco-related-posts',
            'title'             => __('Jeco Related Posts'),
            'description'       => __('A custom block for displaying jeco-related-posts content.'),
            'render_template'   => JECO_BLOCKS_ROOT_PATH . 'blocks/jeco-related-posts/render.php',
            'category'          => 'formatting',
            'icon'              => 'admin-site-alt3',
            'keywords'          => array('jeco-related-posts'),
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
