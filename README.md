# Jeco Blocks

**Plugin Name:** Jeco Blocks  
**Description:** Add custom blocks to your WordPress site.  
**Version:** 1.0.0  
**Author:** Jesus Carrero  

## Description

Jeco Blocks is a WordPress plugin designed to add custom blocks to your website. These blocks are built using the Advanced Custom Fields (ACF) plugin, allowing for flexibility and customization.

## Features

- Custom Gutenberg blocks.
- Conditional loading of block styles.
- Easy integration with ACF fields.
- Command-line interface for creating new blocks.

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- [Advanced Custom Fields (ACF) Plugin](https://wordpress.org/plugins/advanced-custom-fields/) (required)
- [WP-CLI](https://wp-cli.org/) (for block creation command)

## Installation

1. **Upload the plugin files to the `/wp-content/plugins/jeco-blocks` directory**, or install the plugin through the WordPress plugins screen directly.
2. **Activate the plugin** through the 'Plugins' screen in WordPress.
3. Ensure that the [ACF plugin](https://wordpress.org/plugins/advanced-custom-fields/) is installed and activated.

## Usage

Once the plugin is activated, you can use the custom blocks provided by the plugin in the WordPress block editor. Styles for the blocks will be conditionally loaded based on their usage.

### Registering a Block

Custom blocks are registered in the `register-blocks.php` file. An example block is the "Hello World" block, which displays a simple "Hello World" message.

### Enqueuing Block Styles

Block-specific styles are conditionally enqueued based on whether the block is present on the page. This ensures that only necessary CSS is loaded, optimizing page performance.

### Creating a New Block

You can create a new block using the WP-CLI command:

```bash
wp create_block [block_name]
```

Replace [block_name] with the desired name of your block. Spaces in the block name will be replaced with hyphens. The command will:

 - Create a new folder for the block.
 - Generate a render.php file using a template.
 - Create a style.scss file.
 - Register the new block in the register-blocks.php file.

## Frequently Asked Questions

### Why isn't my block showing up?

Ensure that the ACF plugin is installed and activated. This plugin relies on ACF to register custom blocks. Also, make sure to clear any cache if you don't see changes immediately.

### How can I add more blocks?

 - You can add more blocks by editing the `register-blocks.php` file. Follow the pattern used for the "Hello World" block.
 - OR You can add more blocks by using the WP-CLI command provided above. This will automatically set up the necessary files and update the registration file for you.

## Changelog

### 1.0.0

- Initial release.

## License

This plugin is licensed under the [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

## Support

For any issues or feature requests, please contact [Jesus Carrero](jesusenrique.carrero@gmail.com) or open an issue on the [GitHub repository](https://github.com/Jesusjeco/jeco-blocks).

---

*This plugin is developed and maintained by Jesus Carrero.*
