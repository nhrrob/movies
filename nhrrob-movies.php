<?php
/*
Plugin Name: NHRROB Movies
Plugin URI: https://nazmulrobin.com
Description: Build a movie database
Version: 1.0.0
Author: Nazmul Hasan Robin
*/

//Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

//Autoload
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Thee main plugin class
 */
final class Nhrrob_Movies
{

    /**
     * Plugin version
     */
    const VERSION = '1.0';

    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initialize singleton instance
     *
     * @return void
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Initialize plugin
     *
     * @return void
     */
    public function init_plugin()
    {
        if (is_admin()) {
            new \Nhrrob\Movies\Admin();
        }
    }

    /**
     * Define required constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('NHR_MOVIES_VERSION', self::VERSION);
        define('NHR_MOVIES_FILE', __FILE__);
        define('NHR_MOVIES_PATH', __DIR__);
        define('NHR_MOVIES_URL', plugins_url('', NHR_MOVIES_FILE));
        define('NHR_MOVIES_ASSETS', NHR_MOVIES_URL . '/assets');
    }

    /**
     * Do stuff on plugin activation 
     *
     * @return void
     */
    public function activate()
    {
        $installer = new \Nhrrob\Movies\Installer();
        $installer->run();
    }
}

/**
 * Plugin initialization
 *
 * @return void
 */
function nhrrob_movies()
{
    return Nhrrob_Movies::init();
}

nhrrob_movies();
