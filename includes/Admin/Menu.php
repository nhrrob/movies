<?php

namespace Nhrrob\Movies\Admin;

class Menu
{
    public $movie;
    public function __construct($movie)
    {
        $this->movie = $movie;
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu()
    {
        $parent_slug = 'nhrrob-movies'; #ToDo: needed for subpage; coming soon
        $capability = 'manage_options';

        add_menu_page(__('NHR Movies', 'nhrrob-movies'), __('NHR Movies', 'nhrrob-movies'), $capability, $parent_slug, [$this->movie, 'plugin_page'], 'dashicons-laptop');
        
    }
}
