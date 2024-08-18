<?php
/*
Plugin Name: Jeco Auto IP Blacklist
Description: Automatically updates .htaccess with the latest IP blacklist to block spam bots.
Version: 1.0
Author: Jesus Carrero
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    die('Kangaroos cannot jump here');
}

if (!class_exists('JECO_IPBL')) {

    /**
     * Class JECO_IPBL
     *
     * This class handles the functionality of the Jeco Auto IP Blacklist plugin.
     */
    class JECO_IPBL
    {
        /**
         * Plugin version number.
         *
         * @var string
         */
        public $version = '1.0.0';

        /**
         * JECO_IPBL constructor.
         *
         * Initialize hooks and constants.
         */
        public function __construct()
        {
            // Define constants for the plugin
            $this->define('JECO_IPBL', true);
            $this->define('JECO_IPBL_NAME', "JECO_IP_BLACKLIST");
            $this->define('JECO_IPBL_VERSION', $this->version);

            // Initialize hooks
            $this->init_hooks();
        }

        /**
         * Initialize hooks for the plugin.
         *
         * This method sets up activation, deactivation hooks, cron jobs, and admin menu.
         *
         * @return void
         */
        public function init_hooks()
        {
            // Register plugin activation and deactivation hooks
            register_activation_hook(__FILE__, [$this, 'wpcron_activation']);
            register_deactivation_hook(__FILE__, [$this, 'wpcron_deactivation']);

            // Add action for the admin menu
            add_action('admin_menu', [$this, 'add_menu_page']);

            // Register the cron job action
            add_action('jeco_ipbl_script', [$this, 'jeco_ipbl_script']);
        }

        /**
         * Activates the cron job.
         *
         * Schedules the cron job to run daily.
         *
         * @return void
         */
        public function wpcron_activation()
        {
            if (!wp_next_scheduled('jeco_ipbl_script')) {
                wp_schedule_event(time(), 'daily', 'jeco_ipbl_script');
            }
        }

        /**
         * Deactivates the cron job.
         *
         * Unschedules the cron job when the plugin is deactivated.
         *
         * @return void
         */
        public function wpcron_deactivation()
        {
            $timestamp = wp_next_scheduled('jeco_ipbl_script');
            if ($timestamp) {
                wp_unschedule_event($timestamp, 'jeco_ipbl_script');
            }
        }

        /**
         * Executes the IP blacklist update script.
         *
         * This function includes the script to update the .htaccess file with the IP blacklist.
         *
         * @return void
         */
        public function jeco_ipbl_script()
        {
            if (!defined('DOING_CRON')) {
                return;
            }

            // Include the script responsible for updating the .htaccess file
            require_once(plugin_dir_path(__FILE__) . 'phpscript_httaccess_wordpress.php');
        }

        /**
         * Adds a menu item to the WordPress admin dashboard.
         *
         * @return void
         */
        public function add_menu_page()
        {
            if (!current_user_can('manage_options')) {
                return;
            }

            // Add the plugin settings page to the WordPress admin menu
            add_menu_page(
                'Jeco Auto IP Blacklist',    // Page title
                'Jeco Blacklist',            // Menu title
                'manage_options',            // Capability required
                'jeco-auto-ip-blacklist',    // Menu slug
                [$this, 'display_settings_page'], // Callback function
                'dashicons-shield-alt',      // Icon
                100                          // Position
            );
        }

        /**
         * Displays the settings page for the plugin.
         *
         * @return void
         */
        public function display_settings_page()
        {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            // Display the settings page content
            echo '<div class="wrap">';
            echo '<h1>Jeco Auto IP Blacklist</h1>';
            echo '</div>';
        }

        /**
         * Defines a constant if it is not already defined.
         *
         * @param string $name  The constant name.
         * @param mixed  $value The constant value.
         *
         * @return void
         */
        public function define($name, $value = true)
        {
            if (!defined($name)) {
                define($name, $value);
            }
        }
    }

    /**
     * Returns the one true instance of the JECO_IPBL class.
     *
     * This function ensures that the class is instantiated only once.
     *
     * @return JECO_IPBL
     */
    function jeco_ipbl()
    {
        global $jeco_ipbl;

        if (!isset($jeco_ipbl)) {
            $jeco_ipbl = new JECO_IPBL();
        }

        return $jeco_ipbl;
    }

    // Instantiate the plugin
    jeco_ipbl();
}
