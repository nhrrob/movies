<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('New Movie', 'nhrrob-movies') ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error('title') ? ' form-invalid' : ''; ?>">
                    <th scope="row">
                        <label for="title"><?php _e('Title', 'nhrrob-movies') ?></label>
                    </th>

                    <td>
                        <input type="text" name="title" id="title" class="regular-text" value="">
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
                        <textarea type="text" name="description" id="description" class="regular-text"></textarea>
                    </td>
                </tr>

            </tbody>
        </table>

        <?php wp_nonce_field('create-movie'); ?>

        <?php submit_button(__('Add movie', 'nhrrob-movies'), 'primary', 'submit_movie'); ?>
    </form>
</div>