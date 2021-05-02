<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Movies', 'nhrrob-movies') ?></h1>

    <a href="<?= admin_url('admin.php?page=nhrrob-movies&action=create'); ?>" class="page-title-action"><?php _e('Add New', 'nhrrob-movies'); ?></a>

    <?php if (isset($_GET['inserted'])) { ?>
        <div class="notice notice-success">
            <p><?php _e('Movie saved successfully!', 'nhrrob-movies'); ?></p>
        </div>
    <?php } ?>

    <?php if (isset($_GET['movie-deleted']) && $_GET['movie-deleted']=='true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e('Movie deleted successfully!', 'nhrrob-movies'); ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <?php
        $table = new \Nhrrob\Movies\Admin\Movie_List();
        $table->prepare_items();
        $table->display();
        ?>
    </form>
</div>