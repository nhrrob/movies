<?php 

/**
 * Insert a new movie
 *
 * @param array $args
 * @return int|WP_Error
 */
function nhrrob_movies_insert_movie($args = []){
    global $wpdb;

    if(empty($args['title'])){
        return new \WP_Error('no-title',__('You must provide a title','nhrrob-movies'));
    }
    
    $defaults = [
        'title' => '',
        'description' => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time('mysql'),
    ];

    $data = wp_parse_args($args, $defaults);

    if(isset($data['id'])){

        $id = $data['id'];
        unset($data['id']);

        $updated = $wpdb->update(
            "{$wpdb->prefix}nhrrob_movies",
            $data,
            ['id'=> $id],
            [
                '%s',
                '%s',
                '%d',
                '%s',
            ],
            ['%d']
        );
        return $updated;

    }else {
        $inserted = $wpdb->insert(
            "{$wpdb->prefix}nhrrob_movies",
            $data,
            [
                '%s',
                '%s',
                '%d',
                '%s',
            ]
        );
    
        if(! $inserted){
            return new \WP_Error('failed-to-insert', __('Failed to insert data', 'nhrrob-movies'));
        }

        return $wpdb->insert_id;
    }
    
}

/**
 * Fetch movies
 *
 * @param array $args
 * @return array
 */
function nhrrob_movies_get_movies($args = [])
{
    global $wpdb;

    $defaults = [
        'per_page' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);

    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}nhrrob_movies
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['per_page']
             
        )
    );

    return $items;
}

/**
 * Get count of movie
 *
 * @return int
 */
function nhrrob_movies_count()
{
    global $wpdb;

    return (int) $wpdb->get_var("SELECT count('title') FROM {$wpdb->prefix}nhrrob_movies");
}

/**
 * Fetch a single movie from the DB
 *
 * @param int $id
 * @return object 
 */
function nhrrob_movies_get_movie($id)
{
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}nhrrob_movies WHERE id=%d", $id)
    );
}

/**
 * Delete a movie
 *
 * @param int $id
 * @return int|boolean
 */
function nhrrob_movies_delete_movie($id)
{
    global $wpdb;

    return $wpdb->delete(
        "{$wpdb->prefix}nhrrob_movie",
        ['id' => $id],
        ['%d']
    );
}