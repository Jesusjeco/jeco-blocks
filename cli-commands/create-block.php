<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

class Create_Block_Command
{
  public function __invoke($args)
  {
    // Get the block name from the command arguments
    $block_name = sanitize_title_with_dashes($args[0]);

    // Paths for the new block's render template and style
    $render_template = "blocks/$block_name/render.php";
    $style_file = "blocks/$block_name/style.scss";

    // Create the block folder
    if (!file_exists(JECO_BLOCKS_ROOT_PATH . "blocks/$block_name")) {
      mkdir(JECO_BLOCKS_ROOT_PATH . "blocks/$block_name", 0755, true);
    }

    // Use the template to generate the render.php file
    $template_path = JECO_BLOCKS_ROOT_PATH . 'templates/render.php';
    if (file_exists($template_path)) {
      // Read the template content
      $template_content = file_get_contents($template_path);

      // Replace placeholders with the actual block name
      $render_content = str_replace('block_name', esc_attr($block_name), $template_content);

      // Write the modified content to the new render.php file
      file_put_contents(JECO_BLOCKS_ROOT_PATH . $render_template, $render_content);
    } else {
      WP_CLI::error("Template file not found at $template_path");
      return;
    }

    $template_for_style = <<<CODE
        /* Styles for $block_name block */
        .$block_name{}
        CODE;
    // Create an empty style.scss file
    file_put_contents(JECO_BLOCKS_ROOT_PATH . $style_file, $template_for_style);

    // Read the current register-blocks.php file
    $register_file = JECO_BLOCKS_INC_PATH . 'register-blocks.php';
    if (!file_exists($register_file) || !is_writable($register_file)) {
      WP_CLI::error("register-blocks.php file not found or not writable at $register_file");
      return;
    }

    $register_content = file_get_contents($register_file);

    // Create the block registration code
    $block_registration_code = "
    // Register the $block_name block
    acf_register_block_type([
        'name'              => '$block_name',
        'title'             => __('" . ucwords(str_replace('-', ' ', $block_name)) . "'),
        'description'       => __('A custom block for displaying $block_name content.'),
        'render_template'   => JECO_BLOCKS_ROOT_PATH . '$render_template',
        'category'          => 'formatting',
        'icon'              => 'admin-site-alt3',
        'keywords'          => array('$block_name'),
        'supports'          => array(
            'align' => true,
        ),
    ]);\n";

    // Insert the block registration code at line 18
    $lines = explode("\n", $register_content);
    array_splice($lines, 17, 0, $block_registration_code);
    $updated_content = implode("\n", $lines);

    // Write the updated content back to the register-blocks.php file
    file_put_contents($register_file, $updated_content);

    // Output a success message
    WP_CLI::success("Block $block_name has been created and registered.");
  }
}

// Register the command with WP-CLI
if (defined('WP_CLI') && WP_CLI) {
  WP_CLI::add_command('create_block', 'Create_Block_Command');
}
