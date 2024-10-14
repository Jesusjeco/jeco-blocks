<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

class Create_Block_Command
{
  public function __invoke($args)
  {
    $block_name = $this->sanitizeBlockName($args[0]);
    $render_template = "blocks/$block_name/render.php";
    $style_file = "blocks/$block_name/style.scss";
    $style_editor_file = "blocks/$block_name/editor-style.scss";

    $this->createBlockFolder($block_name);
    $this->createRenderFile($block_name, $render_template);
    $this->registerBlock($block_name, $render_template);
    $this->createStyleFile($block_name, $style_file);
    $this->registerStyle($block_name);
    $this->createStyleFile($block_name, $style_editor_file);
    $this->registerEditorStyle($block_name);
  }

  private function sanitizeBlockName($name)
  {
    // Get the block name from the command arguments
    $name = sanitize_title_with_dashes($name);
    // Replace underscores with hyphens in the block name
    return str_replace('_', '-', $name);
  }

  private function createBlockFolder($block_name)
  {
    $block_path = JECO_BLOCKS_ROOT_PATH . "blocks/$block_name";
    if (!file_exists($block_path)) {
      mkdir($block_path, 0755, true);
    }
  }

  private function createRenderFile($block_name, $render_template)
  {
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
  }

  private function registerBlock($block_name, $render_template)
  {
    $register_file = JECO_BLOCKS_INC_PATH . 'register-blocks.php';
    if (!file_exists($register_file) || !is_writable($register_file)) {
      WP_CLI::error("register-blocks.php file not found or not writable at $register_file");
      return;
    }

    $register_content = file_get_contents($register_file);
    $block_registration_code = $this->generateBlockRegistrationCode($block_name, $render_template);
    $updated_content = $this->insertCodeAtLine($register_content, $block_registration_code, 17);

    // Write the updated content back to the register-blocks.php file
    file_put_contents($register_file, $updated_content);
    WP_CLI::success("Block $block_name has been created and registered.");
  }

  private function generateBlockRegistrationCode($block_name, $render_template)
  {
    return "
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
  }

  private function createStyleFile($block_name, $style_file)
  {
    $template_for_style = <<<CODE
        /* Styles for $block_name block */
        @use "../../scss/breakpoints";
        .$block_name {}
        CODE;
    // Create an empty style.scss file
    file_put_contents(JECO_BLOCKS_ROOT_PATH . $style_file, $template_for_style);
  }

  private function registerStyle($block_name)
  {
    $register_file = JECO_BLOCKS_INC_PATH . 'register-styles.php';
    if (!file_exists($register_file) || !is_writable($register_file)) {
      WP_CLI::error("register-styles.php file not found or not writable at $register_file");
      return;
    }

    $register_content = file_get_contents($register_file);
    $style_registration_code = $this->generateStyleRegistrationCode($block_name);
    $updated_content = $this->insertCodeAtLine($register_content, $style_registration_code, 17);

    // Write the updated content back to the register-styles.php file
    file_put_contents($register_file, $updated_content);
    WP_CLI::success("Block $block_name style has been registered.");
  }

  private function registerEditorStyle($block_name)
  {
    $register_file = JECO_BLOCKS_INC_PATH . 'register-editor-styles.php';
    if (!file_exists($register_file) || !is_writable($register_file)) {
      WP_CLI::error("register-editor-styles.php file not found or not writable at $register_file");
      return;
    }

    $register_content = file_get_contents($register_file);
    $style_registration_code = $this->generateEditorStyleRegistrationCode($block_name);
    $updated_content = $this->insertCodeAtLine($register_content, $style_registration_code, 17);

    // Write the updated content back to the register-styles.php file
    file_put_contents($register_file, $updated_content);
    WP_CLI::success("Block $block_name editor style has been registered.");
  }

  private function generateStyleRegistrationCode($block_name)
  {
    return <<<CODE
        // Registering the $block_name styles
        if (has_block('acf/$block_name')) {
            wp_enqueue_style(
              '$block_name-block',
              JECO_BLOCKS_ROOT_URL . 'blocks/$block_name/style.css',
              array(),
              filemtime(JECO_BLOCKS_ROOT_PATH . 'blocks/jeco-introduction-block/style.css')
            );
        }\n
        CODE;
  }

  private function generateEditorStyleRegistrationCode($block_name)
  {
    return <<<CODE
      // Enqueue styles for the editor for $block_name
      if (has_block('acf/$block_name')) {
        wp_enqueue_style(
          '$block_name-editor-style',
          JECO_BLOCKS_ROOT_URL . 'blocks/$block_name/editor-style.css',
          array(),
          filemtime(JECO_BLOCKS_ROOT_PATH . 'blocks/$block_name/editor-style.css')
        );
      }
    CODE;
  }

  private function insertCodeAtLine($content, $code, $line)
  {
    $lines = explode("\n", $content);
    array_splice($lines, $line, 0, $code);
    return implode("\n", $lines);
  }
}

// Register the command with WP-CLI
if (defined('WP_CLI') && WP_CLI) {
  WP_CLI::add_command('create_block', 'Create_Block_Command');
}
