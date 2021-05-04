<?php

namespace Nhrrob\Movies\Admin;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Movie_List extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => 'movie',
            'plural' => 'movies',
            'ajax' => false,
        ]);
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox">',
            'title' => __('Name', 'nhrrob-movies'),
            'description' => __('Description', 'nhrrob-movies'),
            'created_at' => __('Date', 'nhrrob-movies')
        ];
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = [
            'title' => ['title', true],
            'created_at' => ['created_at', true]
        ];

        return $sortable_columns;
    }

    protected function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'value':
                #code
                break;
            default:
                return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

    protected function column_title($item)
    {
        $actions = [];

        $actions['edit'] = sprintf('<a href="%s" title="%s" >%s</a>', admin_url("admin.php?page=nhrrob-movies&action=edit&id=" . $item->id), __('Edit', 'nhrrob-movies'), __('Edit', 'nhrrob-movies'));
        #ToDo
        // $actions['delete'] = sprintf('<a href="%s" class="submitdelete" onclick="return confirm(\'Are You Sure?\');" title="%s" >%s</a>', wp_nonce_url(admin_url("admin-post.php?action=nhrrob-movies-delete-movie&id=" . $item->id), 'nhrrob-movies-delete-movie'), __('Delete', 'nhrrob-movies'), __('Delete', 'nhrrob-movies'));

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s',
            admin_url("admin.php?page=nhrrob-movies&action=edit&id=" . $item->id),
            $item->title,
            $this->row_actions($actions)
        );
    }

    protected function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="movie_id[]" value="%d">',
            $item->id
        );
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        $per_page = 20;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $args = [
            'per_page' => $per_page,
            'offset' => $offset
        ];

        if (isset($_REQUEST['orderby']) && isset($_REQUEST['order'])) {
            $args['orderby'] = sanitize_text_field($_REQUEST['orderby']);
            $args['order'] = sanitize_text_field($_REQUEST['order']);
        }

        $this->items = nhrrob_movies_get_movies($args);


        $this->set_pagination_args([
            'total_items' => nhrrob_movies_count(),
            'per_page' => $per_page,
        ]);
    }
}
