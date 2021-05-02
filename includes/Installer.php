<?php

namespace Nhrrob\Movies;

/**
 * Installer class
 */
class Installer
{

    public function run()
    {
        $this->add_version();
        $this->create_tables();
    }

    public function add_version()
    {
        $installed = get_option('nhrrob_movies_installed');

        if (!$installed) {
            update_option('nhrrob_movies_installed', time());
        }

        update_option('nhrrob_movies_version', NHR_MOVIES_VERSION);
    }

    /**
     * Creating necessary tables
     *
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        #ToDo: Genre, Casts, Director : Coming Soon - Dynamic Data
        $schema = "CREATE TABLE `{$wpdb->prefix}nhrrob_movies` (
                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `title` varchar(255) DEFAULT NULL,
                    `description` varchar(255) DEFAULT NULL,
                    `created_by` bigint(20) NOT NULL,
                    `created_at` datetime DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `id` (`id`)
                ) $charset_collate;";

        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta($schema);
    }
}
