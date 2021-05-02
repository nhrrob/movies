<?php 

namespace Nhrrob\Movies;

use Nhrrob\Movies\Admin\Movie;

//The admin class
class Admin{
    function __construct()
    {
        $movie = new Movie();

        $this->dispatch_actions($movie);
        new Admin\Menu($movie);
    }

    public function dispatch_actions($movie){
        add_action('admin_init', [$movie, 'form_handler']);
        add_action('admin_post_nhrrob-movies-delete-movie', [$movie, 'delete_movie']);
    }
}