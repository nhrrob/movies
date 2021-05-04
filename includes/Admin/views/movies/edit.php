<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Edit Movie', 'nhrrob-movies') ?></h1>

    <?php if (isset($_GET['movie-updated'])) { ?>
        <div class="notice notice-success">
            <p><?php _e('Movie saved successfully!', 'nhrrob-movies'); ?></p>
        </div>
    <?php } ?>
    
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error('title') ? ' form-invalid' : ''; ?>">
                    <th scope="row">
                        <label for="title"><?php _e('Title', 'nhrrob-movies') ?></label>
                    </th>

                    <td>
                        <input type="text" name="title" id="title" class="regular-text" value="<?php echo esc_attr($movie->title); ?>">
                        <?php if ($this->has_error('title')) { ?>
                            <p class="description error"><?php echo $this->get_error('title'); ?></p>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="description"><?php _e('Description', 'nhrrob-movies') ?></label>
                    </th>

                    <td>
                        <textarea type="text" name="description" id="description" class="regular-text"><?php echo esc_textarea($movie->description); ?></textarea>
                    </td>
                </tr>

            </tbody>
        </table>
        <input type="hidden" name="id" value="<?php echo esc_attr($movie->id); ?>">
        <?php wp_nonce_field('create-movie'); ?>

        <?php submit_button(__('Update Movie', 'nhrrob-movies'), 'primary', 'submit_movie'); ?>
    </form>
</div>