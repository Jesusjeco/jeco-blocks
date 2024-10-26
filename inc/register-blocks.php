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

        // Register the yva-footer block
        acf_register_block_type([
            'name'              => 'yva-footer',
            'title'             => __('Yva Footer'),
            'description'       => __('A custom block for displaying yva-footer content.'),
            'render_template'   => JECO_BLOCKS_ROOT_PATH . 'blocks/yva-footer/render.php',
            'category'          => 'formatting',
            'icon'              => 'admin-site-alt3',
            'keywords'          => array('yva-footer'),
            'supports'          => array(
                'align' => true,
            ),
        ]);


        // Register the yva-social-icons-banner block
        acf_register_block_type([
            'name'              => 'yva-social-icons-banner',
            'title'             => __('Yva Social Icons Banner'),
            'description'       => __('A custom block for displaying yva-social-icons-banner content.'),
            'render_template'   => JECO_BLOCKS_ROOT_PATH . 'blocks/yva-social-icons-banner/render.php',
            'category'          => 'formatting',
            'icon'              => 'admin-site-alt3',
            'keywords'          => array('yva-social-icons-banner'),
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
