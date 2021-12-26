<form role="search" method="get" class="search-form" action="<?= esc_url(home_url('/')); ?>" novalidate>
    <label class="sr-only"><?php _e('Search for:', 'single_corse'); ?></label>
    <div class="input-group group-search-form">
        <input type="search" value="<?= get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php echo new_search_placeholder(); ?>" aria-required="true">
        <?php /* if(isset($_GET['termid'])){ ?>
            <input type="hidden" name="termid" value="<?= fixXSS($_GET['termid']); ?>"  placeholder="<?php _e('Search Course', 'single_corse'); ?>">
        <?php } */ ?>
        <span class="input-group-btn">
      <button type="submit" class="search-submit"><?php _e('Search', 'single_corse'); ?></button>
    </span>
    </div>
</form>