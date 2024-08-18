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

if (! class_exists('JECO_IPBL')) {
    class JECO_IPBL
    {
        /**
         * The plugin version number.
         *
         * @var string
         */
        public $version = '1.0.0';

        /**
         * A dummy constructor to ensure JECO_IPBL is only setup once.
         *
         * @date    18/08/24
         * @since   1.0.0
         */
        public function __construct()
        {
            // Do nothing.
        }

        public function initialize()
        {
            // Define constants.
            $this->define('JECO_IPBL', true);
            $this->define('JECO_IPBL_NAME', "JECO_IP_BLACKLIST");
            $this->define('JECO_IPBL', $this->version);

            // Hook to register cron job on plugin activation
            function wpcron_activation()
            {
                if (!wp_next_scheduled('jeco_auto_ip_blacklist')) {
                    wp_schedule_event(time(), 'daily', 'jeco_auto_ip_blacklist');
                }
            }
            register_activation_hook(__FILE__, 'wpcron_activation');

            // Hook to clear cron job on plugin deactivation
            function wpcron_deactivation()
            {
                $timestamp = wp_next_scheduled('jeco_auto_ip_blacklist');
                wp_unschedule_event($timestamp, 'jeco_auto_ip_blacklist');
            }
            register_deactivation_hook(__FILE__, 'wpcron_deactivation');

            // Function to handle the IP blacklist update
            function jeco_auto_ip_blacklist()
            {
                if (!defined('DOING_CRON')) return;

                // Include the script file
                require_once(plugin_dir_path(__FILE__) . 'phpscript_httaccess_wordpress.php');
            }
            add_action('jeco_auto_ip_blacklist', 'jeco_auto_ip_blacklist');

            // Function to add menu item to the WordPress dashboard
            function jeco_auto_ip_blacklist_menu()
            {
                // Check if the current user has admin privileges
                if (!current_user_can('manage_options')) {
                    return;
                }

                add_menu_page(
                    'Jeco Auto IP Blacklist', // Page title
                    'Jeco Blacklist',         // Menu title
                    'manage_options',         // Capability
                    'jeco-auto-ip-blacklist', // Menu slug
                    'jeco_blacklist_settings_page', // Function to display the page
                    'dashicons-shield-alt',   // Icon
                    100                       // Position
                );
            }
            add_action('admin_menu', 'jeco_auto_ip_blacklist_menu');

            // Function to display the settings page content
            function jeco_blacklist_settings_page()
            {
                // Check if the current user has admin privileges
                if (!current_user_can('manage_options')) {
                    wp_die(__('You do not have sufficient permissions to access this page.'));
                }

                echo '<div class="wrap">';
                echo '<h1>Jeco Auto IP Blacklist</h1>';
                echo '</div>';
            }
        } //Initialize

        /**
         * Defines a constant if doesnt already exist.
         *
         * @date    3/5/17
         * @since   5.5.13
         *
         * @param   string $name  The constant name.
         * @param   mixed  $value The constant value.
         * @return  void
         */
        public function define($name, $value = true)
        {
            if (! defined($name)) {
                define($name, $value);
            }
        }
    }

    /**
     * The main function responsible for returning the one true jeco_ipbl Instance to functions everywhere.
     * Use this function like you would a global variable, except without needing to declare the global.
     *
     * Example: <?php $jeco_ipbl = jeco_ipbl(); ?>
     *
     * @date    4/09/13
     * @since   4.3.0
     *
     * @return  JECO_IPBL
     */
    function jeco_ipbl()
    {
        global $jeco_ipbl;

        // Instantiate only once.
        if (! isset($jeco_ipbl)) {
            $jeco_ipbl = new JECO_IPBL();
            $jeco_ipbl->initialize();
        }
        return $jeco_ipbl;
    }

    // Instantiate.
    jeco_ipbl();
}
