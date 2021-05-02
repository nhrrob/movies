<?php

namespace Nhrrob\Movies\Admin;

use Nhrrob\Movies\Traits\Form_Error;

class Movie
{

    use Form_Error;

    public function plugin_page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'create':
                $template = __DIR__ . '/views/movies/create.php';
                break;
            case 'edit':
                $movie = nhrrob_movies_get_movie($id);
                $template = __DIR__ . '/views/movies/edit.php';
                break;
            default:
                $template = __DIR__ . '/views/movies/index.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Handle the form
     *
     * @return void
     */

    public function form_handler()
    {
        if (!isset($_POST['submit_movie'])) {
            return;
        }

        //verify nonce
        if (!wp_verify_nonce($_POST['_wpnonce'], 'create-movie')) {
            wp_die('Permission denied!');
        }

        if (!(current_user_can('manage_options'))) {
            wp_die('Permission denied!');
        }

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $description = isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '';

        if(empty($title)){
            $this->errors['title'] = __('Please provide a title!', 'nhrrob-movies');    
        }

        if(! empty($this->errors)){
            return;
        }

        $args = [
            'title' => $title,
            'description' => $description,
        ];

        if($id){
            $args['id'] = $id;
        }

        $insert_id = nhrrob_movies_insert_movie(
            $args
        );

        if($id){
            $redirected_to = 'admin.php?page=nhrrob-movies&action=edit&movie-updated=true&id='.$id;
        }else {
            $redirected_to = 'admin.php?page=nhrrob-movies&inserted=true';
        }
        wp_redirect($redirected_to);
        exit;
    }

    public function delete_movie(){

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'nhrrob-movies-delete-movie' ) ) {
            wp_die( 'Permission denied!' );
        }

        if (!(current_user_can('manage_options'))) {
            wp_die('Permission denied!');
        }

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if(nhrrob_movies_delete_movie($id)){
            $redirected_to = 'admin.php?page=nhrrob-movies&movie-deleted=true';
        }else {
            $redirected_to = 'admin.php?page=nhrrob-movies&movie-deleted=false';
        }

        wp_redirect($redirected_to);
        exit;
    }
}
