<?php
/*
Plugin Name: Jeco IP Blacklist
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
     * This class handles the functionality of the Jeco IP Blacklist plugin.
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
            // Get the user-defined cron hour, default to 00:00 if not set
            $cron_hour = get_option('jeco_ipbl_cron_hour', '00:00');
            $timestamp = strtotime($cron_hour);

            if (!wp_next_scheduled('jeco_ipbl_script')) {
                // Schedule the event using the user-defined hour
                wp_schedule_event($timestamp, 'daily', 'jeco_ipbl_script');
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

            /**
             * Includes the IP blacklist update script, responsible for updating the .htaccess file
             *
             * This script is provided by MyIP.ms. For more information, visit:
             * https://myip.ms/
             */
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
                'Jeco IP Blacklist',    // Page title
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

            if (isset($_POST['submit'])) {
                check_admin_referer('jeco_ipbl_settings_save'); // Security check
                $cron_hour = sanitize_text_field($_POST['jeco_ipbl_cron_hour']);
                update_option('jeco_ipbl_cron_hour', $cron_hour);

                // Clear the existing cron job
                $timestamp = wp_next_scheduled('jeco_ipbl_script');
                wp_unschedule_event($timestamp, 'jeco_ipbl_script');

                // Reschedule the cron job with the updated hour
                $new_timestamp = strtotime($cron_hour);
                wp_schedule_event($new_timestamp, 'daily', 'jeco_ipbl_script');

                echo '<div class="updated"><p>Settings saved and cron job updated successfully.</p></div>';
            }

            $cron_hour = get_option('jeco_ipbl_cron_hour', '00:00');

            echo '<div class="wrap">';
            echo '<h1>Jeco IP Blacklist</h1>';
            echo '<form method="POST" action="">';
            wp_nonce_field('jeco_ipbl_settings_save');
            echo '<table class="form-table">';
            echo '<tr>';
            echo '<th scope="row"><label for="jeco_ipbl_cron_hour">Cron Job Start Time (HH:MM)</label></th>';
            echo '<td><input type="time" id="jeco_ipbl_cron_hour" name="jeco_ipbl_cron_hour" value="' . esc_attr($cron_hour) . '" /></td>';
            echo '</tr>';
            echo '</table>';
            echo '<p class="submit"><input type="submit" name="submit" class="button-primary" value="Save Changes"></p>';
            echo '</form>';
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
